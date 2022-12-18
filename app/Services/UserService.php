<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\User;

class UserService {
    public static function paging(Request $request) {
        $perPage = isset($request->perPage) ? $request->perPage : 10;
        $page = isset($request->page) ? $request->page : 1;
        $searchKeyword = $request->search;

        $paginator = User::where('email', 'like', "%{$searchKeyword}%")
                                    ->orWhere('first_name', 'like', "%{$searchKeyword}%")
                                    ->orWhere('last_name', 'like', "%{$searchKeyword}%")
                                    ->orWhere('phone', 'like', "%{$searchKeyword}%")
                                    ->paginate($perPage);
        $paginator->appends(['perPage' => $perPage, 'search' => $searchKeyword]);

        foreach($paginator as $item) {
            $file = empty($item->files) ? null : $item->files->first();
            $imgSrc = empty($file) ? null : ($file->path . $file->file_name);
            $item->imgSrc = $imgSrc;
        }

        return $paginator;
    }
}