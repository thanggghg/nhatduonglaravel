<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class AdminSettingController extends Controller
{
    public function index()
    {
        $settings = Setting::orderBy('key')->get()->keyBy('key');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'settings'         => 'required|array',
            'settings.*.key'   => 'required|string',
            'settings.*.value' => 'nullable|string',
        ]);

        foreach ($data['settings'] as $item) {
            Setting::where('key', $item['key'])->update(['value' => $item['value'] ?? '']);
        }

        return redirect()->route('admin.settings.index')->with('success', 'Cài đặt đã được lưu!');
    }
}
