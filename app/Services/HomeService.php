<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\FeaturedProduct;

class HomeService {
    public static function getFeaturedProducts() {
        $now = \Carbon\Carbon::now()->format('Ymd');

        $featuredProducts = FeaturedProduct::where('start_date', '<=', $now)->where('end_date', '>=', $now)->get();
        
        foreach($featuredProducts as $item) {
            $file = empty($item->product) || empty($item->product->files) ? null : $item->product->files->first();
            $imgSrc = empty($file) ? null : ($file->path . $file->file_name);
            $item->imgSrc = $imgSrc;
        }

        return $featuredProducts;
    }

    public static function getLastProducts() {
        $lastProducts = Product::where('active', 1)->orderBy('created_at', 'desc')->limit(5)->get();

        foreach($lastProducts as $item) {
            $file = empty($item->files) ? null : $item->files->first();
            $imgSrc = empty($file) ? null : ($file->path . $file->file_name);
            $item->imgSrc = $imgSrc;
        }

        return $lastProducts;
    }

    public static function getPromotionProducts() {
        $promotionProducts = Product::where('active', 1)->limit(5)->get();

        foreach($promotionProducts as $item) {
            $file = empty($item->files) ? null : $item->files->first();
            $imgSrc = empty($file) ? null : ($file->path . $file->file_name);
            $item->imgSrc = $imgSrc;
        }

        return $promotionProducts;
    }

    public static function getTabProducts() {
        $template = [
            // Block 1
            [
                'block' => [
                    [
                        'tab' => [ 'tabId' => 'tab_LAPTOP', 'tabName' => 'Laptop'], 
                        'items' => ['HFJ885785','HDS650956','GHJ870900','HKD543906','HGJ990799', 'GHJ9405445','GHF594863','GHD472387']
                    ],
                    [
                        'tab' => [ 'tabId' => 'tab_MACBOOK', 'tabName' => 'Macbook'], 
                        'items' => ['GHF594863','GHD472387']
                    ],
                    [
                        'tab' => [ 'tabId' => 'tab_HP', 'tabName' => 'HP'], 
                        'items' => ['HGJ990799','GHJ9405445']
                    ],
                    [
                        'tab' => [ 'tabId' => 'tab_DELL', 'tabName' => 'DELL'], 
                        'items' => ['GHJ870900','HKD543906']
                    ],
                    [
                        'tab' => [ 'tabId' => 'tab_ASUS', 'tabName' => 'ASUS'], 
                        'items' => ['HFJ885785','HDS650956']
                    ],
                ],
                'ads' => 'images/ad_1.jpg'
            ],

            // Block 2
            [
                'block' => [
                    [
                        'tab' => [ 'tabId' => 'tab_SMARTPHONE', 'tabName' => 'Điện thoại'], 
                        'items' => ['SSH986565','SSH88966','IYU198666','IPH589454','IPH878766','IPH5487540','BJG875943','HKJ985493','GHG453655','GHG335456']
                    ],
                    [
                        'tab' => [ 'tabId' => 'tab_APPLE', 'tabName' => 'Apple'], 
                        'items' => ['GHG335456','GHG453655','GHG583493','IYU198666','IPH878766','IPH5487540','IPH958454','IPH589454']
                    ],
                    [
                        'tab' => [ 'tabId' => 'tab_BLACKBERRY', 'tabName' => 'Blackberry'], 
                        'items' => ['BJG875943']
                    ],
                    [
                        'tab' => [ 'tabId' => 'tab_MOTOROLA', 'tabName' => 'Motorola'], 
                        'items' => ['HKJ985493']
                    ],
                    [
                        'tab' => [ 'tabId' => 'tab_SAMSUNG', 'tabName' => 'Samsung'], 
                        'items' => ['SSH88966','SSH986565']
                    ]
                ],
                'ads' => 'images/ad_2.jpg'
            ]
        ];

        foreach($template as $keyBlock => $block) {
            foreach($block['block'] as $keyTab => $tab) {
                foreach($tab['items'] as $index => $item) {
                    $product = Product::where('code', $item)->where('active', 1)->first();

                    if (empty($product)) {
                        unset($template[$keyBlock]['block'][$keyTab]['items'][$index]);
                    } else {
                        $file = empty($product->files) ? null : $product->files->first();
                        $imgSrc = empty($file) ? null : ($file->path . $file->file_name);
                        $product->imgSrc = $imgSrc;
                        
                        $template[$keyBlock]['block'][$keyTab]['items'][$index] = $product;
                    }
                }
            }
        }

        return json_decode(json_encode($template), FALSE);


    }
}