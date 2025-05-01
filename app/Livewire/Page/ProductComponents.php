<?php

namespace App\Livewire\Page;

use App\Models\Product;
use Livewire\Component;

class ProductComponents extends Component
{
    public $slug;
    public $product;
    public $perPage = 6;
    public $productStore;
    public $hasmore;

    // Tangkap parameter dari URL
    public function mount($slug)
    {
        $this->slug = $slug;
        $this->product = Product::with([
            'seller',
            'category',
        ])
            ->where('slug', $slug)
            ->first();
            $this->loadProduct();
    }

    public function loadProduct()
    {
        $query = Product::with(['seller', 'category'])
            ->where('seller_id', $this->product->seller_id)
            ->where('id', '!=', $this->product->id)
            ->paginate($this->perPage);
        $this->productStore = $query->items();
        $this->hasmore = $query->hasMorePages();
    }
    public function loadMore()
    {
        $this->perPage += 12;
        $this->loadProduct();
    }
    public function render()
    {
        return view('livewire.page.product-components')->layout('layouts.app');
    }
}
