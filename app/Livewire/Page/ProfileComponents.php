<?php

namespace App\Livewire\Page;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\WithFileUploads;
use Livewire\Component;
use Livewire\WithPagination;

class ProfileComponents extends Component
{
    use WithFileUploads, WithPagination;

    public $name;
    public $email;
    public $phone;
    public $birthdate;
    public $gender;
    public $photo;
    public $newPhoto;
    public $selectedStatus = 'all';
    public $searchQuery = '';

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->birthdate = $user->birthdate;
        $this->gender = $user->gender;
        $this->photo = $user->photo;
    }

    public function updateProfile()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'birthdate' => 'nullable|date',
            'gender' => 'nullable|string|in:Male,Female',
            'newPhoto' => 'nullable|image|max:10240',
        ]);

        $user = Auth::user();
        $user->name = $this->name;
        $user->phone = $this->phone;
        $user->birthdate = $this->birthdate;
        $user->gender = $this->gender;

        if ($this->newPhoto) {
            $path = $this->newPhoto->store('profile-photos', 'public');
            $user->photo = $path;
        }

        $user->save();
        session()->flash('message', 'Profil berhasil diperbarui!');
    }

    public function getFilteredOrders()
    {
        $q = DB::table('orders as o')
            ->join('order_items as oi', 'oi.order_id', '=', 'o.id')
            ->join('products as p', 'oi.product_id', '=', 'p.id')
            ->leftJoin('payments as pa', 'o.id', '=', 'pa.order_id')
            ->where('o.buyer_id', Auth::user()->id)
            ->select(
                'o.id as order_id',
                'o.status as order_status',
                'o.created_at as order_date',
                'o.total_price as total_order_price',
                'oi.qty',
                'oi.id as order_item_id',
                'p.name as product_name',
                'p.price as product_price',
                'p.primary_image as product_primary_image',
                'pa.payment_method',
                'pa.payment_status'
            );

        // **Filter berdasarkan Status Order**
        if ($this->selectedStatus !== 'all') {
            $q->where('o.status', $this->selectedStatus);
        }

        // **Pencarian berdasarkan Order ID atau Nama Produk**
        if (!empty($this->searchQuery)) {
            $q->where(function ($query) {
                $query->where('o.id', 'like', "%{$this->searchQuery}%")
                    ->orWhere('p.name', 'like', "%{$this->searchQuery}%");
            });
        }

        return $q->paginate(10);
    }
    public function render()
    {
        return view('livewire.page.profile-components', [
            'orders' => $this->getFilteredOrders()
        ])->layout('layouts.app');
    }
}
