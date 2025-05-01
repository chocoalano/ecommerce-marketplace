<?php

namespace App\Livewire\Components;

use App\Models\Cart;
use Auth;
use Livewire\Component;
use App\Models\Product;

class ProductDetail extends Component
{
    public $quantity = 1;
    public $currentIndex = 0;

    // Assuming you have a Product model for data
    public $product;

    public function mount($productId)
    {
        $this->product = Product::with(
            'seller',
            'category',
        )
            ->where('id', $productId)
            ->first();
    }

    public function next()
    {
        $this->currentIndex = ($this->currentIndex + 1) % (count($this->items) / 5);
        $this->loadItems(); // Reload items with sequential colors when moving to the next
    }

    public function prev()
    {
        $this->currentIndex = ($this->currentIndex - 1 + (count($this->items) / 5)) % (count($this->items) / 5);
        $this->loadItems(); // Reload items with sequential colors when moving to the previous
    }

    public function incrementQuantity()
    {
        $this->quantity++;
    }

    public function decrementQuantity()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function addToCart($id)
    {
        if (Auth::check()) {
            $productData = Product::find($id);
            
            if (!$productData) {
                return redirect()->back()->with('error', 'Produk tidak ditemukan');
            }
        
            $cartItem = Cart::where('buyer_id', Auth::user()->id)
                            ->where('product_id', $id)
                            ->first();
        
            if ($cartItem) {
                // Jika produk sudah ada di keranjang, tambahkan qty dan update total_price
                $cartItem->qty += $this->quantity;
                $cartItem->total_price += $productData->price * $this->quantity;
                $cartItem->save();
            } else {
                // Jika produk belum ada di keranjang, buat entri baru
                Cart::create([
                    'buyer_id' => Auth::user()->id,
                    'product_id' => $id,
                    'qty' => $this->quantity,
                    'total_price' => $productData->price * $this->quantity
                ]);
            }
        
            return redirect(route('cart'))->with('success', 'Produk berhasil ditambahkan ke keranjang');
        } else {
            return redirect(route('account'))->with('error', 'Silakan login terlebih dahulu');
        }
        
    }
    public function render()
    {
        return view('livewire.components.product-detail');
    }
}
