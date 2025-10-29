<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::orderBy('id', 'desc')->get();
        return view('admin.page.brand', compact('brands'));
    }

    public function create()
{
   
    return view('admin.page.edit.brand');
}


public function store(Request $request)
{
   
    try {
        
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:brands,name',
            'image' => 'nullable|image|max:20048',
        ]);

      
        if ($request->hasFile('image')) {
            $validated['image'] = upload_image(
                $request->file('image'),
                'uploads/brands',
                ['width' => 100, 'height' => 100]
            );
        }

         Brand::create($validated);

        return redirect()
            ->route('brands.index')
            ->with('success', 'Brands created successfully!');

    } catch (\Exception $e) {
       
        Log::error('Brands creation failed: ' . $e->getMessage());

       
        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'Failed to create Brands. Please try again.');
    }

}


public function edit($id)

{   $brand = Brand::findOrFail($id);
    
   
       
    return view('admin.page.edit.brand', compact('brand'));
    
}


public function update(Request $request, $id)
{
    try {
        $brands = Brand::findOrFail($id);

      
        $validated = $request->validate([
              'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('brands')->ignore($brands->id),
            ],
            'parent_id' => 'nullable|integer',
            'image' => 'nullable|image|max:20048',
        ]);

      
        if ($request->hasFile('image')) {
            $validated['image'] = update_image(
                $request->file('image'),
                $brands->image, 
                'uploads/brands',
                ['width' => 100, 'height' => 100]
            );
        }

             $brands->update($validated);

        return redirect()->route('brands.index')->with('success', 'Brands updated successfully!');

    } catch (\Exception $e) {
        Log::error('brands update failed: ' . $e->getMessage());

        return redirect()->back()->withInput()->with('error', 'Failed to update brands. Please try again.');
    }
}



 public function delete($id)
    {
 try {
       
        $brand = Brand::findOrFail($id);

       
        if ($brand->image) {
            delete_image($brand->image);
        }

       
        $brand->delete();
 return redirect()->route('brands.index')->with('success', 'Brands deleted successfully');

    } catch (\Exception $e) {
      
        Log::error('Brands deletion failed: ' . $e->getMessage());
 return redirect()->back()->withInput()->with('error', 'Failed to delete Brands. Please try again.');
        
    }
    }





}
