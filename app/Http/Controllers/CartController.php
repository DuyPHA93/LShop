<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CartService;
use Session;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cart = CartService::getObjectCart();
        // var_dump($cart); exit();

        return view('pages/user/cart')->with('cart', $cart);
    }

    public function add(Request $request) {
        CartService::addItem($request);

        return back();
    }

    public function update(Request $request) {
        CartService::update($request);

        return back();
    }
}
