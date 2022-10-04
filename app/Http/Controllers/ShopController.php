<?php

namespace App\Http\Controllers;
use App\Models\Area; 
use App\Models\Shop;

use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
    // 1対多 主->従
    $shops = Area::find(1)->shops;
    // 主 <- 従
    $area = Shop::find(3)->area->name;

    // 多対多
    $routes = Shop::find(1)->routes()->get();
    dd($area, $shops, $routes);
    }   
}
