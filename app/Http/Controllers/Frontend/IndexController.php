<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        $homeCategories = Category::where('status', 'published')
        ->select('id', 'name', 'slug', 'image')
        ->orderBy('name')
        ->take(6) 
        ->get();
       
        $recentProducts = Product::where('status', 'published')
        ->select('id', 'name', 'slug', 'selling_price', 'main_image')
        ->latest()             
        ->take(6)               
        ->get();

        return view('frontend.index', compact('recentProducts', 'homeCategories'));
    }

    
}
