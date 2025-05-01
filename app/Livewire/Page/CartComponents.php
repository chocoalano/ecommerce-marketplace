<?php
namespace App\Livewire\Page;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CartComponents extends Component
{
    public $items = [];
    public $subtotal, $discount, $total;

    protected $listeners = ['cartUpdated' => 'refreshCart'];

    public function mount()
    {
        // Cek autentikasi saat halaman dimuat
        if (!Auth::check()) {
            return redirect()->route('account'); // Jika tidak terautentikasi, arahkan ke halaman akun
        }
        
        $this->loadCart(); // Muat data keranjang jika sudah terautentikasi
    }

    public function toggleCheckbox($event, $id)
    {
        $isChecked = $event ? true : false;

        try {
            $c = Cart::findOrFail($id); // Menggunakan findOrFail untuk memastikan item ada
            $c->ispay = $isChecked;
            $c->save();
        } catch (\Throwable $th) {
            // Jika terjadi kesalahan, bisa ditangani atau dilog
            // Misalnya, menggunakan Log::error($th)
            throw $th;
        }
    }

    public function checkout()
    {
        // Arahkan ke halaman checkout
        return redirect()->route('cart.checkout');
    }

    public function loadCart()
    {
        // Ambil item keranjang menggunakan relasi Eloquent
        $this->items = Cart::with('product', 'product.seller')
            ->where('buyer_id', Auth::id())
            ->get();

        // Menghitung subtotal, diskon, dan total
        $this->subtotal = $this->items->sum(fn($item) => $item->qty * $item->product->price);
        $this->discount = 0.1 * $this->subtotal;
        $this->total = $this->subtotal - $this->discount;
    }

    public function refreshCart()
    {
        $this->loadCart(); // Muat ulang keranjang
    }

    public function increment($id)
    {
        $cartItem = Cart::findOrFail($id);
        
        if ($cartItem && $cartItem->qty < $cartItem->product->stock) {
            $cartItem->increment('qty');
            $cartItem->update(['total_price' => $cartItem->qty * $cartItem->product->price]);
        }

        $this->refreshCart(); // Perbarui keranjang setelah increment
    }

    public function decrement($id)
    {
        $cartItem = Cart::findOrFail($id);
        
        if ($cartItem) {
            if ($cartItem->qty > 1) {
                $cartItem->decrement('qty');
                $cartItem->update(['total_price' => $cartItem->qty * $cartItem->product->price]);
            } else {
                $cartItem->delete(); // Hapus item jika qty = 1
            }
        }

        $this->refreshCart(); // Perbarui keranjang setelah decrement
    }

    public function removeItem($id)
    {
        Cart::destroy($id); // Hapus item berdasarkan ID
        $this->refreshCart(); // Perbarui keranjang setelah penghapusan
    }

    public function render()
    {
        return view('livewire.page.cart-components')->layout('layouts.app');
    }
}
