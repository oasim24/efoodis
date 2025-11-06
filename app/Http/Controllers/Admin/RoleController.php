<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
class RoleController extends Controller
{
    public function index()
    {
       $roles = Role::with('permissions')->get();
        $permissions = Permission::all();
        return view('admin.page.role', compact('roles', 'permissions'));
    }

public function create()
{
     $permissions = Permission::all();
        return view('admin.page.edit.role', compact('permissions'));
}
public function edit($id)
{
     $role = Role::with('permissions')->find($id);
     $permissions = Permission::all();
        return view('admin.page.edit.role', compact('permissions', 'role'));
}



 public function store(Request $request)
    {
        $validated = $request->validate([
            'role' => 'required|string|max:255',
            'permissions' => 'nullable|array',
        ]);

      
        $role = Role::create([
            'name' => $validated['role'],
            'slug' => Str::slug($validated['role']),
        ]);

       
        if (!empty($validated['permissions'])) {
            $role->permissions()->sync($validated['permissions']);
        }

         return redirect()
            ->route('roles.index')
            ->with('success', 'Role "' . $role->name . '" updated successfully.');
    }


   public function update(Request $request, $id)
{
    try {
       

       
        $role = Role::findOrFail($id);

       
        $validated = $request->validate([
            'role' => 'required|string|max:255',
            'permissions' => 'nullable|array',
        ]);

       
        $role->update([
            'name' => $validated['role'],
            'slug' => Str::slug($validated['role']),
        ]);

       
        if (!empty($validated['permissions'])) {
            $role->permissions()->sync($validated['permissions']);
        } else {
            $role->permissions()->sync([]); 
        }

        return redirect()
            ->route('roles.index')
            ->with('success', 'Role "' . $role->name . '" updated successfully.');

    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        
        return redirect()
            ->back()
            ->with('error', 'Role not found!');

    } catch (\Illuminate\Validation\ValidationException $e) {
        
        return redirect()
            ->back()
            ->withErrors($e->validator)
            ->withInput();

    } catch (\Exception $e) {
      
        Log::error('Role update failed: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);

        return redirect()
            ->back()
            ->with('error', 'Something went wrong while updating the role. Please try again.');
    }

}


public function delete($id)
{
    try {
        $role = Role::findOrFail($id);

        
        $role->permissions()->detach();

      
        $role->delete();

        return back()->with('success', 'Role deleted successfully.');

    } catch (\Exception $e) {
        Log::error('Role delete failed: ' . $e->getMessage());
        return back()->with('error', 'Failed to delete user. Please try again.');
    }
}



}
