<?php

namespace App\Livewire\Page;

use App\Models\Order;
use App\Models\Cart;
use App\Models\Payment;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use App\Support\RajaOngkir;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class CheckoutComponents extends Component
{
    use WithFileUploads;
    public array $product = [];
    public array $provinces = [];
    public array $cities = [];
    public array $ongkir_paket = [];
    public array $cartForm = [];
    public bool $isOpen = false;

    public array $authForm = [
        'province' => null,
        'city' => null,
        'address' => null,
    ];
    public array $paymentConfirmationForm = [
        'order_id' => null,
        'payment_method' => null,
        'payment_status' => null,
        'payment_date' => null,
        'amount_paid' => null,
        'image' => null,
    ];

    public function __construct()
    {
        $this->rajaOngkir = new RajaOngkir();
    }

    public function mount(): void
    {
        $this->loadProvinces();
        $this->loadUserData();
        $this->loadCartData();
    }

    private function loadProvinces(): void
    {
        try {
            $data = $this->rajaOngkir->getProvinces();
            $this->provinces = collect($data)->map(fn($prov) => [
                'id' => $prov['province_id'],
                'name' => $prov['province'],
            ])->toArray();
        } catch (\Exception $e) {
            \Log::error("Gagal mengambil provinsi: " . $e->getMessage());
        }
    }

    private function loadUserData(): void
    {
        $user = Auth::user();
        $this->authForm = [
            'province' => $user->raja_ongkir_province_id,
            'city' => $user->raja_ongkir_city_id,
            'address' => $user->full_address,
        ];

        if (!empty($this->authForm['province'])) {
            $this->loadCities($this->authForm['province']);
        }
    }

    private function loadCartData(): void
    {
        $carts = Cart::where(['buyer_id' => Auth::id(), 'ispay' => 1])
            ->with(['product.seller'])
            ->get();
        $this->product = $carts->toArray();

        $this->cartForm = $carts->map(fn($cart) => [
            'product_id' => $cart->product->id,
            'qty' => $cart->qty,
            'item_price' => $cart->product->price,
            'total_price' => $cart->total_price,
            'total_weight' => ($cart->product->weight * $cart->qty),
            'province_store' => $cart->product->seller->province,
            'city_store' => $cart->product->seller->city,
            'province_id_ro_shipping' => $this->authForm['province'] ?? null,
            'city_id_ro_shipping' => $this->authForm['city'] ?? null,
            'courier_ro_shipping' => null,
            'packet_ro_shipping' => null,
            'cost_ro_shipping' => null,
            'list_ro_shipping_option' => null,
        ])->toArray();
    }

    public function setOngkir(string $value, int $index): void
    {
        $data = explode('|', $value);
        if (count($data) === 2) {
            $this->cartForm[$index]['packet_ro_shipping'] = $data[0];
            $this->cartForm[$index]['cost_ro_shipping'] = $data[1];
        }
    }

    public function ongkirCheck(int $originCity, int $destinationCity, int $weight, string $courier, int $index): void
    {
        try {
            $this->cartForm[$index]['courier_ro_shipping'] = $courier;
            $cost = $this->rajaOngkir->getCost($originCity, $destinationCity, $weight, $courier);
            $this->ongkir_paket[$index] = $cost[0]['costs'] ?? [];
        } catch (\Exception $e) {
            \Log::error("Gagal menghitung ongkir: " . $e->getMessage());
        }
    }

    public function changeProvince(?int $provinceId): void
    {
        if (!$provinceId) {
            $this->cities = [];
            return;
        }
        $this->loadCities($provinceId);
    }

    private function loadCities(int $provinceId): void
    {
        try {
            $data = $this->rajaOngkir->getCities($provinceId);
            $this->cities = collect($data)->map(fn($city) => [
                'id' => $city['city_id'],
                'name' => $city['city_name'],
            ])->toArray();
        } catch (\Exception $e) {
            \Log::error("Gagal mengambil kota: " . $e->getMessage());
            $this->cities = [];
        }
    }

    public function saveAddress(): void
    {
        Auth::user()->update($this->authForm);
        session()->flash('message', 'Alamat berhasil diperbarui!');
    }

    public function submitCheckout(): void
    {
        $this->show();
    }
    public function submitKonfirmasiPembayaran(): void
    {
        $this->validate([
            'paymentConfirmationForm.image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'paymentConfirmationForm.image.required' => 'Bukti pembayaran wajib diunggah.',
            'paymentConfirmationForm.image.image' => 'File yang diunggah harus berupa gambar.',
            'paymentConfirmationForm.image.mimes' => 'Format gambar harus jpeg, png, atau jpg.',
            'paymentConfirmationForm.image.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        // Pastikan keranjang tidak kosong
        if (empty($this->cartForm) || !is_array($this->cartForm)) {
            session()->flash('error', 'Keranjang belanja tidak boleh kosong.');
            return;
        }

        DB::transaction(function () {
            $userId = Auth::id();
            $totalPrice = collect($this->cartForm)->sum('total_price');
            // Cek apakah order sudah ada untuk user yang belum diproses
            $order = Order::where('buyer_id', $userId)
                ->where('status', 'pending')
                ->first();

            if (!$order) {
                $order = Order::create([
                    'buyer_id' => $userId,
                    'status' => 'pending',
                    'total_price' => $totalPrice,
                ]);
                $path = $this->paymentConfirmationForm['image']->store('bukti_pembayaran', 'public');
                Payment::create([
                    'image_path' => $path,
                    'order_id' => $order->id,
                    'payment_method' => 'transfer_bank',
                    'payment_status' => 'pending',
                    'payment_date' => now(),
                    'amount_paid' => $totalPrice,
                ]);
            } else {
                // Jika order sudah ada, pastikan total_price tetap diperbarui
                $order->update(['total_price' => $totalPrice]);
            }

            // Pastikan relasi `items` dimuat
            $order->loadMissing('item');

            // Dapatkan produk yang sudah ada dalam order
            $existingProductIds = $order->item->pluck('product_id')->toArray();

            // Filter item baru yang belum ada dalam order
            $newItems = collect($this->cartForm)->reject(function ($item) use ($existingProductIds) {
                return in_array($item['product_id'], $existingProductIds);
            })->toArray();

            if (!empty($newItems)) {
                $order->item()->createMany($newItems);
            }
        });

        session()->flash('message-checkout-konfirmation', 'Bukti pembayaran berhasil diunggah.');
        $this->hide();

        // Redirect ke halaman profile setelah transaksi berhasil
        $this->redirect(route('auth.profile'));
    }
    public function show()
    {
        $this->isOpen = true;
    }

    public function hide()
    {
        $this->isOpen = false;
    }

    public function render()
    {
        return view('livewire.page.checkout-components')->layout('layouts.app');
    }
}
