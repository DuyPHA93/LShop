<?php

namespace App\Services;

use Illuminate\Http\Request;
use Session;

use App\Models\Product;

class CartService {
    public static function addItem(Request $request) {
        $cart = Session::get('cart');

        if (empty($cart)) $cart = self::initCart();

        $product = Product::find($request->id);

        if (isset($product)) {
            $cart = self::add($cart, $product->id, $request->quantity, ($product->price * $request->quantity));
            Session::put('cart', $cart);
            Session::flash('cart-msg', "“". $product->name ."” đã được thêm vào giỏ hàng.");
        }
    }

    public static function initCart() {
        return [
            'totalAmount' => 0,
            'totalQuantity' => 0,
            'items' => []
        ];
    }

    public static function add($cart, $id, $quantity, $price) {
        $indexDuplicate = null;

        foreach($cart['items'] as $key => $item) {
            if ($item['id'] == $id) {
                $indexDuplicate = $key;
                break;
            }
        }

        $cart['totalAmount'] += $price;
        $cart['totalQuantity'] += $quantity;

        if (isset($indexDuplicate)) {
            $cart['items'][$indexDuplicate]['quantity'] += $quantity;
        } else {
            array_push($cart['items'], ['id' => $id, 'quantity' => $quantity]);
        }

        return $cart;
    }

    public static function update(Request $request) {
        $cart = self::initCart();

        foreach($request->all() as $key => $value) {
            if (str_contains($key , 'productId_')) {
                $id = (int) str_replace("productId_","",$key);
                $product = Product::find($id);

                if (isset($product)) {
                    $cart = self::add($cart, $product->id, $value, ($product->price * $value));
                }
            }
        }

        Session::put('cart', $cart);
    }

    public static function getObjectCart() {
        $cart = Session::get('cart');

        if (isset($cart) && isset($cart['items'])) {
            foreach($cart['items'] as $key => $item) {
                $product = Product::find($item['id']);

                if (isset($product)) {
                    $file = empty($product->files) ? null : $product->files->first();
                    $imgSrc = empty($file) ? null : ($file->path . $file->file_name);
                    $product->imgSrc = $imgSrc;
                }

                $cart['items'][$key]['product'] = $product;
            }
        }

        return \json_decode(json_encode($cart));
    }
}