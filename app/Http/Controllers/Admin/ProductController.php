<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Categories;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
class ProductController extends Controller
{
    public function index()
{
    $products = Product::orderBy('id', 'desc')->get(); 
    return view('admin.page.product', compact('products'));
}

public function create()
{
    $categories = Categories::whereNull('parent_id')
        ->pluck('name', 'id'); 
    $brands = Brand::pluck('name', 'id'); 
       
    return view('admin.page.edit.product', compact('categories', 'brands'));
}


public function store(Request $request)
{
   
    try {
        
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:products,name',
            'old_price' => 'nullable|numeric',
            'new_price' => 'required|numeric',
            'stock' => 'required|numeric',
            'category_id' => 'required|integer',
            'brand_id' => 'nullable|integer',
            'description' => 'nullable|string',
            'thumbnail_image' => 'nullable|image|max:20048',
            'feature_image' => 'nullable|array',
            'feature_image.*' => 'image|max:20048', 
        ]);

      
        if ($request->hasFile('thumbnail_image')) {
            $validated['thumbnail_image'] = upload_image(
                $request->file('thumbnail_image'),
                'uploads/products',
                ['width' => 300, 'height' => 300]
            );
        }

      
        $galleryPaths = [];
        if ($request->hasFile('feature_image')) {
            foreach ($request->file('feature_image') as $img) {
                $galleryPaths[] = upload_image(
                    $img,
                    'uploads/products/feature',
                    ['width' => 300, 'height' => 300]
                );
            }
        }
        $validated['feature_image'] = json_encode($galleryPaths);

      
        $product = Product::create($validated);

      
        $product->update([
            'slug' => Str::slug($product->name),
            'code' => 'P0' . $product->id,
            'status' => 1,
        ]);

        return redirect()
            ->route('products.index')
            ->with('success', 'Product created successfully!');

    } catch (\Exception $e) {
       
        Log::error('Product creation failed: ' . $e->getMessage());

       
        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'Failed to create product. Please try again.');
    }
}


public function edit($id)

{   $product = Product::findOrFail($id);
     $categories = Categories::whereNull('parent_id')
        ->pluck('name', 'id'); 
    $brands = Brand::pluck('name', 'id'); 
       
    return view('admin.page.edit.product', compact('categories', 'brands', 'product'));
    
}

public function update(Request $request, $id)
{
    try {
        $product = Product::findOrFail($id);

      
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('products')->ignore($product->id),
            ],
            'old_price' => 'nullable|numeric',
            'new_price' => 'required|numeric',
            'stock' => 'required|numeric',
            'category_id' => 'required|integer',
            'brand_id' => 'nullable|integer',
            'description' => 'nullable|string',
            'thumbnail_image' => 'nullable|image|max:20048',
            'feature_image' => 'nullable|array',
            'feature_image.*' => 'image|max:20048',
        ]);

      
        if ($request->hasFile('thumbnail_image')) {
            $validated['thumbnail_image'] = update_image(
                $request->file('thumbnail_image'),
                $product->thumbnail_image, 
                'uploads/products',
                ['width' => 300, 'height' => 300]
            );
        }

      
        $galleryPaths = [];
        if ($request->hasFile('feature_image')) {
            foreach ($request->file('feature_image') as $img) {
                $galleryPaths[] = update_image(
                    $img,
                    $product->feature_image,
                    'uploads/products/feature',
                    ['width' => 300, 'height' => 300]
                );
            }
        }

        if (!empty($galleryPaths)) {
            $validated['feature_image'] = json_encode($galleryPaths);
        }

      
        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Product updated successfully!');

    } catch (\Exception $e) {
        Log::error('Product update failed: ' . $e->getMessage());

        return redirect()->back()->withInput()->with('error', 'Failed to update product. Please try again.');
    }
}

public function delete($id)
{
    try {
       
        $product = Product::findOrFail($id);

       
        if ($product->thumbnail_image) {
            delete_image($product->thumbnail_image);
        }

       
      if ($product->feature_image) {
    $featureImages = json_decode($product->feature_image, true); 
    if (is_array($featureImages)) {
        foreach ($featureImages as $img) {
            delete_image($img);
        }
    }
}

       
        $product->delete();
 return redirect()->route('products.index')->with('success', 'Product deleted successfully');

    } catch (\Exception $e) {
      
        Log::error('Product deletion failed: ' . $e->getMessage());
 return redirect()->back()->withInput()->with('error', 'Failed to delete product. Please try again.');
        
    }
}


}
