<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\CartService;
use App\Services\CheckoutService;
use Session;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = CartService::getObjectCart();
        return view('pages/user/checkout-form')->with('cart', $cart);
    }

    public function perform(Request $request)
    {
        // Validate the request...
        $validated = $request->validate([
            'firstName' => 'required',
            'lastName' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required|email'
        ]);

        $orderNo = CheckoutService::checkout($request);
        if (isset($orderNo)) {
            $cart = CartService::getObjectCart();
            Session::forget('cart');
            
            return view('pages/user/checkout-success')  ->with('orderNo', $orderNo)
                                                        ->with('cart', $cart)
                                                        ->with('timeOrder', \Carbon\Carbon::now()->format('H:i:s'))
                                                        ->with('dateOrder', \Carbon\Carbon::now()->format('d/m/Y'));
        }
    }
}
