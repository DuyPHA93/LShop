<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderLine;
use App\Services\OrderService;

class OrderController extends Controller
{
    // Master
    // Order List Master Page
    public function masterList(Request $request)
    {
        $orders = OrderService::paging($request);
        return view('pages/admin/orders')->with('orders', $orders);
    }

    // Master
    // Order Detail Master Page
    public function masterDetail(Request $request)
    {
        $order = Order::find($request->id);
        $orderLines = OrderLine::where('order_no', $order->order_no)->get();
        $personOrder = User::find($order->person_order_id);
        foreach($orderLines as $item) {
            $file = empty($item->product) || empty($item->product->files) ? null : $item->product->files->first();
            $imgSrc = empty($file) ? null : ($file->path . $file->file_name);
            $item->imgSrc = $imgSrc;
        }
        return view('pages/admin/order-detail') ->with('order', $order)
                                                ->with('orderLines', $orderLines)
                                                ->with('personOrder', $personOrder);
    }

    public function save(Request $request) {
        return OrderService::apply($request);
    }
}
