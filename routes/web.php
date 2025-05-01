<?php
use App\Livewire\Page\AccountComponents;
use App\Livewire\Page\CartComponents;
use App\Livewire\Page\CatalogComponents;
use App\Livewire\Page\CheckoutComponents;
use App\Livewire\Page\HomeComponents;
use App\Livewire\Page\PageComponents;
use App\Livewire\Page\ProductComponents;
use App\Livewire\Page\ProfileComponents;
use App\Livewire\Page\TrekingComponents;
use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return redirect()->route('account');
})->name('login');

Route::get('/', HomeComponents::class)->name('home');
Route::get('/produk/{slug}', ProductComponents::class)->name('produk.detail');
Route::get('/account', AccountComponents::class)->name('account');
Route::get('/catalog/{slug}', CatalogComponents::class)->name('catalog.detail');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/cart', CartComponents::class)->name('cart');
    Route::get('/checkout', CheckoutComponents::class)->name('cart.checkout');
    Route::get('/profile', ProfileComponents::class)->name('auth.profile');
    Route::get('/treking/{id}', TrekingComponents::class)->name('auth.treking');
    Route::get('/page/{pagename}', PageComponents::class)->name('page');
});
