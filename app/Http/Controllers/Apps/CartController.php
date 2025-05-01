<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return view('pages.cart');
        }
        return view('pages.account');
    }
    public function checkout()
    {
        if (Auth::check()) {
            return view('pages.checkout');
        }
        return view('pages.account');
    }
}
