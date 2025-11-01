<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Osinfo;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
class SettingController extends Controller
{
    public function index()
    {  $settings = Setting::first()->get();
       $osinfo = Osinfo::all();

        return view('admin.page.setting', compact('settings', 'osinfo'));
    }


public function edit($id)

{   $setting = Setting::findOrFail($id);
    
   
       
    return view('admin.page.edit.setting', compact('setting'));
    
}
public function osedit($id)

{   $osinfo = Osinfo::findOrFail($id);
    
   
       
    return view('admin.page.edit.osinfo', compact('osinfo'));
    
}



public function update(Request $request, $id)
{
    try {
        $settings = setting::findOrFail($id);

      
        $validated = $request->validate([
              'name' => 'required|string|max:255',
              'phone' => 'required|string|max:255',
              'email' => 'required|string|max:255',
              'address' => 'required|string|max:255',
            'logo' => 'nullable|image|max:20048',
            'favicon' => 'nullable|image|max:20048',
        ]);

      
        if ($request->hasFile('logo')) {
            $validated['logo'] = update_image(
                $request->file('logo'),
                $settings->logo, 
                'uploads/settings',
                ['width' => 200, 'height' => 50]
            );
        }
        if ($request->hasFile('favicon')) {
            $validated['favicon'] = update_image(
                $request->file('favicon'),
                $settings->favicon, 
                'uploads/settings',
                ['width' => 30, 'height' => 30]
            );
        }

             $settings->update($validated);

        return redirect()->route('settings.index')->with('success', 'Settings updated successfully!');

    } catch (\Exception $e) {
        Log::error('Settings update failed: ' . $e->getMessage());

        return redirect()->back()->withInput()->with('error', 'Failed to update Settings. Please try again.');
    }
}



public function osupdate(Request $request, $id)
{
    try {
        $osinfos = Osinfo::findOrFail($id);

      
        $validated = $request->validate([
              'value' => 'required|string|max:255',
              
        ]);

      
       
       

             $osinfos->update($validated);

        return redirect()->route('settings.index')->with('success', 'Settings updated successfully!');

    } catch (\Exception $e) {
        Log::error('Settings update failed: ' . $e->getMessage());

        return redirect()->back()->withInput()->with('error', 'Failed to update Settings. Please try again.');
    }
}


}
