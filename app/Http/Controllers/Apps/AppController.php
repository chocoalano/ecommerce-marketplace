<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\Seller;

class AppController extends Controller
{
    public function index()
    {
        return view('pages.home');
    }
    public function account()
    {
        return view('pages.account');
    }
}
