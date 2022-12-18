<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Session;

use App\Models\Order;
use App\Models\OrderLine;

class CheckoutService {
    public static function checkout(Request $request) {
        DB::beginTransaction();
        try {
            $orderNo = null;
            $cart = CartService::getObjectCart();

            $order = self::createOrder($request);

            if (isset($order)) {
                foreach($cart->items as $item) {
                    self::createOrderLine($order->order_no, $item);
                }

                $orderNo = $order->order_no;
            }

            DB::commit();
            return $orderNo;
            
        } catch( Exception $e) {
            DB::rollBack();
            return null;
        }
    }

    public static function generateOrderNo() {
		$prefix = \Carbon\Carbon::now()->format('Ymd');
		$maxTail = self::getMaxTailOrderNo($prefix);
		
		if ($maxTail == -1) {
			return $prefix . "01";
		} else if ($maxTail >= 0) {
			return $prefix . str_pad($maxTail + 1,2,'0',STR_PAD_LEFT);
		}
		
		return null;
	}

    public static function getMaxTailOrderNo($prefix) {
        $order = Order::where('order_no', 'like', "{$prefix}%")->orderBy('order_no', 'desc')->first();

        if (isset($order)) {
            return (int) str_replace($prefix,"",$order->order_no);
        }

        return -1;
    }

    public static function createOrder(Request $request)
    {
        return Order::create([
            'order_no' => self::generateOrderNo(),
            'order_date' => \Carbon\Carbon::now()->format('Y-m-d'),
            'person_order_id' => Auth::user()->id,
            'contact_first_name' => $request->firstName,
            'contact_last_name' => $request->lastName,
            'contact_email' => $request->email,
            'contact_phone' => $request->phone,
            'contact_address' => $request->address,
            'note' => $request->note,
            'status' => 'dang_cho_nhan_hang',
            'total_quantity' => Session::get('cart')['totalQuantity'],
            'total_price' => Session::get('cart')['totalAmount']
        ]);
    }

    public static function createOrderLine($orderNo, $itemCart)
    {
        return OrderLine::create([
            'order_no' => $orderNo,
            'product_id' => $itemCart->id,
            'product_quantity' => $itemCart->quantity,
            'product_total_price' => $itemCart->product->price * $itemCart->quantity,
            'status' => 'dang_cho_nhan_hang'
        ]);
    }
}