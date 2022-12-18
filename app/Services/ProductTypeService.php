<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\ProductType;

class ProductTypeService {
    public static function paging(Request $request) {
        $perPage = isset($request->perPage) ? $request->perPage : 10;
        $page = isset($request->page) ? $request->page : 1;
        $searchKeyword = $request->search;

        $paginator = ProductType::where('code', 'like', "%{$searchKeyword}%")
                                    ->orWhere('name', 'like', "%{$searchKeyword}%")
                                    ->paginate($perPage);
        $paginator->appends(['perPage' => $perPage, 'search' => $searchKeyword]);

        foreach($paginator as $item) {
            $file = empty($item->files) ? null : $item->files->first();
            $imgSrc = empty($file) ? null : ($file->path . $file->file_name);
            $item->imgSrc = $imgSrc;
        }

        return $paginator;
    }

    public static function getCategoryMenu() {
        $categories = ProductType::where('active', 1)->get();

        foreach($categories as $item) {
            $file = empty($item->files) ? null : $item->files->first();
            $imgSrc = empty($file) ? null : ($file->path . $file->file_name);
            $item->imgSrc = $imgSrc;
        }

        return $categories;
    }
}