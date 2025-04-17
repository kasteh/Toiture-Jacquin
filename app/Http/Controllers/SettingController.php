<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function edit()
    {
        return view('admin.settings.edit', [
            'settings' => Setting::all()->pluck('value', 'key')
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'primary_color' => 'required|string',
            'hero_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
        ]);

        $primaryColorSetting = Setting::firstOrNew(['key' => 'primary_color']);
        $primaryColorSetting->value = $request->primary_color;
        $primaryColorSetting->save();

        if ($request->hasFile('hero_image')) {
            $imagePath = $request->file('hero_image')->store('images', 'public');
            $heroImageSetting = Setting::firstOrNew(['key' => 'hero_image']);
            $heroImageSetting->value = $imagePath;
            $heroImageSetting->save();
        }

        return redirect()->back()->with('success', 'Configuration mise à jour.');
    }
}
