<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();
        return view('admin.page.user', compact('users'));
    }

    public function create()
    {
        $roles = Role::pluck('name', 'id'); ;
        return view('admin.page.edit.user', compact('roles'));
    }


public function store(Request $request)
{
    try {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:3',
            'roles' => 'required|array',
        ]);

      
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);

       
        $user->roles()->sync($validated['roles']);

        return back()->with('success', 'User created successfully with assigned roles: ' . $user->name);

    } catch (\Exception $e) {
       
        Log::error('User creation failed: ' . $e->getMessage(), [
            'trace' => $e->getTraceAsString(),
        ]);

        
        return back()->with('error', 'Something went wrong while creating the user. Please try again.');
    }
}



 public function edit($id)
{
    $user = User::with('roles')->findOrFail($id);

    
    $selectedRoles = $user->roles->pluck('id')->toArray();

   
    $roles = Role::pluck('name', 'id');

    return view('admin.page.edit.user', compact('user', 'roles', 'selectedRoles'));
}


public function update(Request $request, $id)
{
    try {
        $user = User::findOrFail($id);

       
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:3',
            'roles' => 'required|array',
        ]);

       
        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

      
        $user->roles()->sync($validated['roles']);

        return redirect()
            ->route('users.index')
            ->with('success', 'User updated successfully.');

    } catch (\Exception $e) {
        Log::error('User update failed: ' . $e->getMessage());
        return back()->with('error', 'Failed to update user. Please try again.');
    }
}



public function delete($id)
{
    try {
        $user = User::findOrFail($id);

        
        $user->roles()->detach();

      
        $user->delete();

        return back()->with('success', 'User deleted successfully.');

    } catch (\Exception $e) {
        Log::error('User delete failed: ' . $e->getMessage());
        return back()->with('error', 'Failed to delete user. Please try again.');
    }
}





}
