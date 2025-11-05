<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
       $roles = Role::with('permissions')->get();
        $permissions = Permission::all();
        return view('admin.page.role', compact('roles', 'permissions'));
    }

 public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:roles,slug',
            'permissions' => 'nullable|array',
        ]);

      
        $role = Role::create([
            'name' => $validated['name'],
            'slug' => $validated['slug'],
        ]);

       
        if (!empty($validated['permissions'])) {
            $role->permissions()->sync($validated['permissions']);
        }

        return back()->with('success', 'Role created successfully with permissions.');
    }


     public function update(Request $request, Role $role)
    {
        $role->permissions()->sync($request->permissions ?? []);
        return back()->with('success', 'Permissions updated for ' . $role->name);
    }

}
