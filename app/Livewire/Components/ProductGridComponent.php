<?php

namespace App\Livewire\Components;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ProductGridComponent extends Component
{
    use WithPagination;

    public $products = [];
    public $perPage = 20;
    public $hasMorePages = false;

    public function mount()
    {
        $this->loadProducts();
    }

    public function loadProducts()
    {
        $query = Product::with('seller')
        ->where('status', 'active')
        ->paginate($this->perPage);
        $this->products = $query->items(); // Konversi ke array agar Livewire tidak error
        $this->hasMorePages = $query->hasMorePages();
    }

    public function loadMore()
    {
        $this->perPage += 10;
        $this->loadProducts();
    }

    public function render()
    {
        return view('livewire.components.product-grid-component', [
            'products' => $this->products,
        ]);
    }
}