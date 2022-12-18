<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Order;
use App\Models\OrderLine;

class OrderService {
    public static function paging(Request $request) {
        $perPage = isset($request->perPage) ? $request->perPage : 10;
        $page = isset($request->page) ? $request->page : 1;
        $searchKeyword = $request->search;

        $paginator = Order::where('order_no', 'like', "%{$searchKeyword}%")
                                    ->orWhere('contact_address', 'like', "%{$searchKeyword}%")
                                    ->orWhere('total_quantity', $searchKeyword)
                                    ->paginate($perPage);
        $paginator->appends(['perPage' => $perPage, 'search' => $searchKeyword]);

        return $paginator;
    }

    public static function apply(Request $request) {
        DB::beginTransaction();
        try {
            $orderNo = $request->orderNo;
            $order = Order::where('order_no', $orderNo)->first();
            $orderLines = OrderLine::where('order_no', $orderNo)->get();

            if (isset($order)) {
                if ($order->status == 'dang_cho_nhan_hang') {
                    if (isset($request->isDeny)) {
                        self::updateDenyOrderStatus($request, $order, $orderLines);
                    } else {
                        self::updateReiceiveOrderStatus($order, $orderLines);
                    }
                } else if ($order->status == 'da_nhan_hang') {
                    self::updateDeliveringOrderStatus($request, $order, $orderLines);
                } else if ($order->status == 'dang_giao_hang') {
                    self::updateDeliveredOrderStatus($order, $orderLines);
                }  else if ($order->status == 'da_giao_hang') {
                    self::updateCompleteOrderStatus($order, $orderLines);
                }
            }

            DB::commit();
            return response()
                ->json(['status' => 200, 'message' => 'Successfully!', 'data' => null]);

        } catch (Exception $e) {
            DB::rollBack();
            return response()
                ->json(['status' => 500, 'message' => 'Error!', 'data' => null]);
        }
    }

    public static function updateStatus($order, $orderLines, $status) {
        $order->status = $status;
        $order->save();

        foreach($orderLines as $orderLine) {
            $orderLine->status = $status;
            $orderLine->save();
        }

        return $order;
    }

    public static function updateReiceiveOrderStatus($order, $orderLines) {
        $order->receive_order_date = \Carbon\Carbon::now()->format('Y-m-d');

        $order = self::updateStatus($order, $orderLines, 'da_nhan_hang');

        return $order;
    }

    public static function updateDeliveringOrderStatus(Request $request, $order, $orderLines) {
        $order->warehouse_pickup = $request->warehousePickup;
        $order->shipping_code = $request->shippingCode;
        $order->transporter = $request->transporter;
        $order->shipping_status = 'dang_giao_hang';
        $order->total_weight = $request->totalWeight;
        $order->delivery_date = \Carbon\Carbon::now()->format('Y-m-d');

        $order = self::updateStatus($order, $orderLines, 'dang_giao_hang');

        return $order;
    }

    public static function updateDeliveredOrderStatus($order, $orderLines) {
        $order->shipping_status = 'da_giao_hang';
        $order->delivered_date = \Carbon\Carbon::now()->format('Y-m-d');

        $order = self::updateStatus($order, $orderLines, 'da_giao_hang');

        return $order;
    }

    public static function updateCompleteOrderStatus($order, $orderLines) {
        $order->confirm_complete_order_date = \Carbon\Carbon::now()->format('Y-m-d');

        $order = self::updateStatus($order, $orderLines, 'hoan_thanh');

        return $order;
    }

    public static function updateDenyOrderStatus(Request $request, $order, $orderLines) {
        $order->reason_for_cancel_order = $request->reasonCancelOrder;

        $order = self::updateStatus($order, $orderLines, 'da_huy');

        return $order;
    }
}