<?php

namespace App\Http\Controllers;

use App\Models\Categories;
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
    $product = Product::where('slug', $slug)->with('categories')->firstOrFail();

    
    $relatedProducts = Product::where('categories_id', $product->category_id)
        ->where('id', '!=', $product->id) 
        ->where('status', 1) 
        ->take(10) 
        ->inRandomOrder() 
        ->get();

    return view('frontend.page.details', compact('product', 'relatedProducts'));
}



public function categories(Request $request, $id)
{
    
    $categories = Categories::where('parent_id', $id)->get();

   
    $minPrice = Product::min('new_price');
    $maxPrice = Product::max('new_price');

   
    $cats = Categories::with(['products' => function ($query) use ($request, $minPrice, $maxPrice) {
        
        if ($request->has('min_price') && $request->min_price != null) {
            $query->where('new_price', '>=', $request->min_price);
        }
        if ($request->has('max_price') && $request->max_price != null) {
            $query->where('new_price', '<=', $request->max_price);
        }
    }])->findOrFail($id);

  
    return view('frontend.page.categories', compact('cats', 'categories', 'id', 'minPrice', 'maxPrice'));
}








}
