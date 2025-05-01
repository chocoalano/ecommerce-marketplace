<?php

namespace App\Livewire;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class TopupComponents extends Component
{
    use WithFileUploads;
    public bool $isOpen = false;
    public array $paymentConfirmationForm = [
        'payment_method' => null,
        'amount_paid' => null,
        'image' => null,
    ];

    public function show()
    {
        $this->isOpen = true;
    }

    public function hide()
    {
        $this->isOpen = false;
    }

    public function submit()
    {
        $this->show();
    }

    public function submitKonfirmasiPembayaran(): void
    {
        // Validasi Input
        $this->validate([
            'paymentConfirmationForm.image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'paymentConfirmationForm.payment_method' => 'required|string',
            'paymentConfirmationForm.amount_paid' => 'required|numeric|min:1000',
        ], [
            'paymentConfirmationForm.image.required' => 'Bukti pembayaran wajib diunggah.',
            'paymentConfirmationForm.image.image' => 'File yang diunggah harus berupa gambar.',
            'paymentConfirmationForm.image.mimes' => 'Format gambar harus jpeg, png, atau jpg.',
            'paymentConfirmationForm.image.max' => 'Ukuran gambar maksimal 2MB.',
            'paymentConfirmationForm.payment_method.required' => 'Pilih metode pembayaran.',
            'paymentConfirmationForm.amount_paid.required' => 'Nominal pembayaran harus diisi.',
            'paymentConfirmationForm.amount_paid.numeric' => 'Nominal pembayaran harus berupa angka.',
            'paymentConfirmationForm.amount_paid.min' => 'Nominal minimal Rp1.000.',
        ]);

        try {
            DB::beginTransaction();

            // Simpan gambar ke storage
            $path = $this->paymentConfirmationForm['image']
                ->store('bukti_pembayaran', 'public');

            // Simpan data pembayaran
            $payment = Payment::create([
                'image_path' => $path,
                'payment_method' => $this->paymentConfirmationForm['payment_method'],
                'payment_status' => 'pending',
                'payment_date' => now(),
                'amount_paid' => $this->paymentConfirmationForm['amount_paid'],
            ]);

            if ($payment) {
                // Tambah saldo e-wallet user
                User::where('id', Auth::id())
                ->increment('ewallet_balance', $this->paymentConfirmationForm['amount_paid']);
            }

            DB::commit();

            // Reset form & beri notifikasi sukses
            $this->reset('paymentConfirmationForm');
            session()->flash('message-checkout-konfirmation', 'Bukti pembayaran berhasil diunggah.');
            $this->redirect(route('auth.profile'));

        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();
            Log::error('Gagal mengkonfirmasi pembayaran: ' . $e->getMessage());
            session()->flash('error', 'Terjadi kesalahan saat memproses pembayaran. Silakan coba lagi.');
        }
    }

    public function render()
    {
        return view('livewire.topup-components');
    }
}
