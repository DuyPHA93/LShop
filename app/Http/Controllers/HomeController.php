<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\HomeService;

class HomeController extends Controller
{
    public function index()
    {
        return view('pages/user/home')  ->with('featuredProducts', HomeService::getFeaturedProducts())
                                        ->with('lastProducts', HomeService::getLastProducts())
                                        ->with('promotionProducts', HomeService::getPromotionProducts())
                                        ->with('productBlocks', HomeService::getTabProducts())
                                        ->with('isHome', true);
    }
}
