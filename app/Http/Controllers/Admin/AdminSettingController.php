<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class AdminSettingController extends Controller
{
    public function index()
    {
        $settings = Setting::orderBy('group')->orderBy('key')->get();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'settings'              => 'required|array',
            'settings.*.key'        => 'required|string',
            'settings.*.type'       => 'nullable|string',
            'settings.*.group'      => 'nullable|string',
            'settings.*.value'      => 'nullable|string',
            'settings.*.value_file' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:20480',
        ]);

        foreach ($data['settings'] as $index => $item) {
            $setting = Setting::firstOrNew(['key' => $item['key']]);
            $setting->type = $item['type'] ?? $setting->type ?? 'text';
            $setting->group = $item['group'] ?? $setting->group;

            $value = $item['value'] ?? $setting->value ?? '';

            if ($request->hasFile("settings.$index.value_file")) {
                if ($setting->type === 'image' && is_string($setting->value) && trim($setting->value) !== '') {
                    Storage::disk('public')->delete($setting->value);
                }

                $value = $request->file("settings.$index.value_file")->store('settings', 'public');
            }

            $setting->value = $value;
            $setting->save();
        }

        Artisan::call('optimize:clear');

        return redirect()->route('admin.settings.index')->with('success', 'Cài đặt đã được lưu!');
    }
}
