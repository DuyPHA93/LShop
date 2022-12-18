<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\FeaturedProduct;

class FeaturedProductService {
    public static function paging(Request $request) {
        $perPage = isset($request->perPage) ? $request->perPage : 10;
        $page = isset($request->page) ? $request->page : 1;
        $searchKeyword = $request->search;
        $now = \Carbon\Carbon::now()->format('Ymd');

        $paginator = FeaturedProduct::where(function($query) use ($searchKeyword, $now) {
                                        if ($searchKeyword == 1) {
                                            $query->where('start_date', '<=', $now)->where('end_date', '>=', $now);
                                        } else if ($searchKeyword == 2) {
                                            $query->where('start_date', '>', $now);
                                        } else if ($searchKeyword == 3) {
                                            $query->where('end_date', '<', $now);
                                        }
                                    })
                                    ->orderBy('product_id', 'asc')
                                    ->orderBy('start_date', 'asc')
                                    ->paginate($perPage);
        $paginator->appends(['perPage' => $perPage, 'search' => $searchKeyword]);

        foreach($paginator as $item) {
            $file = empty($item->product) || empty($item->product->files) ? null : $item->product->files->first();
            $imgSrc = empty($file) ? null : ($file->path . $file->file_name);
            $item->imgSrc = $imgSrc;

            $now = \Carbon\Carbon::createFromFormat('Y-m-d', \Carbon\Carbon::now()->format('Y-m-d'));
            $startDate = \Carbon\Carbon::createFromFormat('Y-m-d', $item->start_date);
            $endDate = \Carbon\Carbon::createFromFormat('Y-m-d', $item->end_date);
            $item->active = $now->gte($startDate) && $now->lte($endDate) ? true : false;
        }

        return $paginator;
    }

    public static function checkDuplicate($productId, $excludeId, $startDate, $endDate) {
        $startDate = \Carbon\Carbon::createFromFormat('d/m/Y', $startDate)->format('Ymd');
        $endDate = \Carbon\Carbon::createFromFormat('d/m/Y', $endDate)->format('Ymd');

        $result = FeaturedProduct::where('product_id', $productId)
                        ->where('id', '<>', $excludeId)
                        ->where(function($query) use ($startDate, $endDate) {
                            $query->where(function($query) use ($startDate, $endDate) {
                                $query->where('start_date', '<=', $startDate)->where('end_date', '>=', $startDate);
                            })      ->orWhere(function($query) use ($startDate, $endDate) {
                                $query->where('start_date', '<=', $endDate)->where('end_date', '>=', $endDate);
                            })      ->orWhere(function($query) use ($startDate, $endDate) {
                                $query->where('start_date', '>=', $startDate)->where('start_date', '<=', $endDate);
                            })      ->orWhere(function($query) use ($startDate, $endDate) {
                                $query->where('end_date', '>=', $startDate)->where('end_date', '<=', $endDate);
                            });
                        })->get();

        return $result->count() > 0 ? true : false;
    }
}