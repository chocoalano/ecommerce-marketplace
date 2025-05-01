<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.catalog');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        // Fetch the product along with related data
        $product = Product::with([
            'seller',
            'category',
        ])
            ->where('slug', $slug)
            ->first();

        // Check if the product exists
        if (!$product) {
            // Handle the case where product is not found (optional: you can redirect to a 404 page or show an error message)
            return redirect()->route('catalog.index')->with('error', 'Product not found.');
        }

        // Fetch related products by the same seller
        $productStore = Product::with(['seller', 'category'])
            ->where('seller_id', $product->seller_id)
            ->where('id', '!=', $product->id)
            ->get();

        // Return the view with the product and related products
        return view('pages.catalog_detail', compact('product', 'productStore'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
