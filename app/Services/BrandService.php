<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Brand;

class BrandService {
    public static function paging(Request $request) {
        $perPage = isset($request->perPage) ? $request->perPage : 10;
        $page = isset($request->page) ? $request->page : 1;
        $searchKeyword = $request->search;

        $paginator = Brand::where('code', 'like', "%{$searchKeyword}%")
                                    ->orWhere('name', 'like', "%{$searchKeyword}%")
                                    ->orWhereHas('productType', function (Builder $query) use ($searchKeyword) {
                                        $query->where('name', 'like', "%{$searchKeyword}%");
                                    })
                                    ->paginate($perPage);
        $paginator->appends(['perPage' => $perPage, 'search' => $searchKeyword]);

        return $paginator;
    }
}