<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class AdminDashboardController extends Controller
{


    public function index()
    {
        return view('admin.dashboard', [
            'productCount'       => Product::count(),
            'categoryCount'      => Category::count(),
            'syncedProducts'     => Product::whereNotNull('hub_product_id')->count(),
            'unsyncedProducts'   => Product::whereNull('hub_product_id')->count(),
            'syncedCategories'   => Category::whereNotNull('hub_category_id')->count(),
            'unsyncedCategories' => Category::whereNull('hub_category_id')->count(),
            'recentProducts'     => Product::latest()->take(5)->get(),
        ]);
    }
}
