<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
class CategoryController extends Controller
{
    public function index()
{
    $category = Categories::orderBy('id', 'desc')->with('children')->whereNull('parent_id')->get();
    return view('admin.page.category', compact('category'));
}

    public function create()
{
    $categories = Categories::whereNull('parent_id')
        ->pluck('name', 'id'); 
    return view('admin.page.edit.category', compact('categories'));
}


public function store(Request $request)
{
   
    try {
        
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'parent_id' => 'nullable|integer',
            'image' => 'nullable|image|max:20048',
        ]);

      
        if ($request->hasFile('image')) {
            $validated['image'] = upload_image(
                $request->file('image'),
                'uploads/categories',
                ['width' => 100, 'height' => 100]
            );
        }

         Categories::create($validated);

        return redirect()
            ->route('categories.index')
            ->with('success', 'categories created successfully!');

    } catch (\Exception $e) {
       
        Log::error('Categories creation failed: ' . $e->getMessage());

       
        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'Failed to create Categories. Please try again.');
    }

}



public function edit($id)

{   $cat = Categories::findOrFail($id);
    $categories = Categories::whereNull('parent_id')
        ->pluck('name', 'id');  
   
       
    return view('admin.page.edit.category', compact('categories', 'cat'));
    
}



public function update(Request $request, $id)
{
    try {
        $categories = Categories::findOrFail($id);

      
        $validated = $request->validate([
              'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories')->ignore($categories->id),
            ],
            'parent_id' => 'nullable|integer',
            'image' => 'nullable|image|max:20048',
        ]);

      
        if ($request->hasFile('image')) {
            $validated['image'] = update_image(
                $request->file('image'),
                $categories->image, 
                'uploads/categories',
                ['width' => 100, 'height' => 100]
            );
        }

             $categories->update($validated);

        return redirect()->route('categories.index')->with('success', 'Categories updated successfully!');

    } catch (\Exception $e) {
        Log::error('categories update failed: ' . $e->getMessage());

        return redirect()->back()->withInput()->with('error', 'Failed to update Categories. Please try again.');
    }
}






    public function delete($id)
    {
 try {
       
        $cat = Categories::findOrFail($id);

       
        if ($cat->image) {
            delete_image($cat->image);
        }

       
        $cat->delete();
 return redirect()->route('categories.index')->with('success', 'Categories deleted successfully');

    } catch (\Exception $e) {
      
        Log::error('Categories deletion failed: ' . $e->getMessage());
 return redirect()->back()->withInput()->with('error', 'Failed to delete categories. Please try again.');
        
    }
    }
}
