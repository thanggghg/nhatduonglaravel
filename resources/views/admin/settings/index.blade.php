@extends('admin.layouts.app')
@section('title', 'Cài đặt hệ thống')
@section('page-title', 'Cài đặt hệ thống')
@section('content')
<div class="max-w-2xl">
    <form method="POST" action="{{ route('admin.settings.update') }}">
        @csrf @method('PUT')
        <div class="bg-canvas-white rounded-lg shadow-md p-32 mb-24">
            <h3 class="text-heading font-semibold text-forest-deep mb-24">Thông tin website</h3>
            @foreach($settings as $key => $setting)
            <div class="mb-24">
                <label class="block text-body-sm font-medium text-slate-text mb-8">
                    {{ ucwords(str_replace('_', ' ', $key)) }}
                </label>
                <input type="hidden" name="settings[{{ $loop->index }}][key]" value="{{ $key }}">
                @if(in_array($key, ['description', 'address']))
                    <textarea name="settings[{{ $loop->index }}][value]" rows="3"
                        class="w-full px-16 py-12 border border-input-border rounded-md text-body focus:outline-none focus:ring-2 focus:ring-brand-green">{{ $setting->value ?? '' }}</textarea>
                @else
                    <input type="text" name="settings[{{ $loop->index }}][value]" value="{{ $setting->value ?? '' }}"
                        class="w-full px-16 py-12 border border-input-border rounded-md text-body focus:outline-none focus:ring-2 focus:ring-brand-green">
                @endif
            </div>
            @endforeach
        </div>
        <div class="flex gap-12">
            <button type="submit" class="bg-brand-green text-canvas-white font-semibold py-14 px-28 rounded-md hover:bg-green-hover">Lưu cài đặt</button>
        </div>
    </form>
</div>
@endsection
