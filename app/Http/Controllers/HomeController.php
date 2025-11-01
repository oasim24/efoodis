<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
         $all = Product::where('status', 1)->orderBy('id', 'desc')->get(); 
         $hots = Product::where('hot', 1)->orderBy('id', 'desc')->get(); 
         $featurs = Product::where('feature', 1)->orderBy('id', 'desc')->get(); 
         $tops = Product::where('top_sell', 1)->orderBy('id', 'desc')->get(); 
           

        return view('welcome', compact('all', 'hots', 'tops', 'featurs'));
    }

public function details($slug)
{
    $product = Product::where('slug', $slug)->with('category')->firstOrFail();

    
    $relatedProducts = Product::where('category_id', $product->category_id)
        ->where('id', '!=', $product->id) 
        ->where('status', 1) 
        ->take(10) 
        ->inRandomOrder() 
        ->get();

    return view('frontend.page.details', compact('product', 'relatedProducts'));
}

}
