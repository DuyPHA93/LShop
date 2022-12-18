<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\Brand;

class ProductService {
    public static function paging(Request $request) {
        $perPage = isset($request->perPage) ? $request->perPage : 10;
        $page = isset($request->page) ? $request->page : 1;
        $searchKeyword = $request->search;

        $paginator = Product::where('code', 'like', "%{$searchKeyword}%")
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

    public static function search(Request $request) {
        $page = isset($request->page) ? $request->page : 1;
        $searchKeyword = $request->search;
        $productTypeId = $request->type;
        $brandId = $request->brand;

        $paginator = Product::where('name', 'like', "%{$searchKeyword}%")
                            ->where(function($query) use ($productTypeId, $brandId)  {
                                if(isset($productTypeId)) {
                                    $query->where('product_type_id', $productTypeId);
                                }

                                if(isset($brandId)) {
                                    $query->where('brand_id', $brandId);
                                }
                             })->paginate(16);
        $paginator->appends(['search' => $searchKeyword, 'type' => $productTypeId, 'brand' => $brandId]);

        $paginator->from = (($paginator->currentPage() - 1) * $paginator->perPage()) + 1;
        $paginator->to = (($paginator->currentPage() - 1) * $paginator->perPage()) + $paginator->count();

        if (isset($productTypeId)) {
            $productType = ProductType::find($productTypeId);
            $paginator->productTypeId = $productType->id;
            $paginator->productTypeName = $productType->name;   
        }

        if (isset($brandId)) {
            $brand = Brand::find($brandId);  
            $paginator->productTypeId = $brand->productType->id;
            $paginator->productTypeName = $brand->productType->name;
            $paginator->brandName = $brand->name;
        }

        foreach($paginator as $item) {
            $file = empty($item->files) ? null : $item->files->first();
            $imgSrc = empty($file) ? null : ($file->path . $file->file_name);
            $item->imgSrc = $imgSrc;
        }

        return $paginator;
    }

    public static function getRandomProducts($exceptId) {
        $products = Product::where('active', 1)
                            ->where('id', '!=', $exceptId)
                            ->inRandomOrder()
                            ->limit(6)
                            ->get();

        foreach($products as $item) {
            $file = empty($item->files) ? null : $item->files->first();
            $imgSrc = empty($file) ? null : ($file->path . $file->file_name);
            $item->imgSrc = $imgSrc;
        }

        return $products;
    }
 }