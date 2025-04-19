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
            'hero_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'hero_small_title' => 'nullable|string|max:255',
            'hero_main_title' => 'nullable|string|max:255',
            'hero_description' => 'nullable|string',
            'hero_bullets' => 'nullable|string',
            'faq_main_title' => 'nullable|string',
            'presentation_content' => 'nullable|string',
        ]);

        // Liste des clés à mettre à jour (hors image)
        $settingsData = [
            'primary_color' => $request->input('primary_color'),
            'hero_small_title' => $request->input('hero_small_title'),
            'hero_main_title' => $request->input('hero_main_title'),
            'hero_description' => $request->input('hero_description'),
            'hero_bullets' => $request->input('hero_bullets'),
            'faq_main_title' => $request->input('faq_main_title'),
            'presentation_content' => $request->input('presentation_content'),
        ];

        // Sauvegarde des réglages textuels
        foreach ($settingsData as $key => $value) {
            $setting = Setting::firstOrNew(['key' => $key]);
            $setting->value = $value ?? '';
            $setting->save();
        }

        // Sauvegarde de l'image si elle est présente
        if ($request->hasFile('hero_image')) {
            $imagePath = $request->file('hero_image')->store('images', 'public');
            $heroImageSetting = Setting::firstOrNew(['key' => 'hero_image']);
            $heroImageSetting->value = $imagePath;
            $heroImageSetting->save();
        }

        return redirect()->back()->with('success', 'Configuration mise à jour.');
    }
}
