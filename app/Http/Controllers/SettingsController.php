<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function update(Request $request)
    {
        // حفظ الإعدادات العامة
        $data = $request->only(['site_name', 'support_email', 'site_locale']);
        foreach ($data as $key => $value) {
            \App\Models\Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
        // حفظ الشعار إذا تم رفعه
        if ($request->hasFile('site_logo') && $request->file('site_logo')->isValid()) {
            $logo = $request->file('site_logo')->store('settings', 'public');
            \App\Models\Setting::updateOrCreate(['key' => 'site_logo'], ['value' => $logo]);
        }
        return redirect()->route('settings')->with('success', 'تم حفظ الإعدادات بنجاح');
    }

    public static function get($key, $default = null)
    {
        $setting = \App\Models\Setting::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }
}
