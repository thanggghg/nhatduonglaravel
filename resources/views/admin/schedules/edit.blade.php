@extends('admin.layouts.app')
@section('title', 'Chỉnh sửa lịch trình')
@section('page-title', 'Chỉnh sửa lịch trình')
@section('content')
<div class="max-w-2xl">
    <form method="POST" action="{{ route('admin.schedules.update', $schedule->id) }}">
        @csrf @method('PUT')
        <div class="bg-canvas-white rounded-lg shadow-md p-32 mb-24">
            <div class="mb-24">
                <label class="block text-body-sm font-medium text-slate-text mb-8">Tuyến xe <span class="text-red-500">*</span></label>
                <select name="route_id" required class="w-full px-16 py-12 border border-input-border rounded-md text-body focus:outline-none focus:ring-2 focus:ring-brand-green">
                    <option value="">-- Chọn tuyến xe --</option>
                    @foreach($routes as $route)
                        <option value="{{ $route->id }}" {{ old('route_id', $schedule->route_id) == $route->id ? 'selected' : '' }}>{{ $route->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="grid grid-cols-2 gap-24 mb-24">
                <div>
                    <label class="block text-body-sm font-medium text-slate-text mb-8">Giờ khởi hành <span class="text-red-500">*</span></label>
                    <input type="time" name="departure_time" value="{{ old('departure_time', $schedule->departure_time ? \Carbon\Carbon::parse($schedule->departure_time)->format('H:i') : '') }}" required
                        class="w-full px-16 py-12 border border-input-border rounded-md text-body focus:outline-none focus:ring-2 focus:ring-brand-green">
                </div>
                <div>
                    <label class="block text-body-sm font-medium text-slate-text mb-8">Giờ đến</label>
                    <input type="time" name="arrival_time" value="{{ old('arrival_time', $schedule->arrival_time ? \Carbon\Carbon::parse($schedule->arrival_time)->format('H:i') : '') }}"
                        class="w-full px-16 py-12 border border-input-border rounded-md text-body focus:outline-none focus:ring-2 focus:ring-brand-green">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-24 mb-24">
                <div>
                    <label class="block text-body-sm font-medium text-slate-text mb-8">Loại xe</label>
                    <input type="text" name="vehicle_type" value="{{ old('vehicle_type', $schedule->vehicle_type) }}"
                        class="w-full px-16 py-12 border border-input-border rounded-md text-body focus:outline-none focus:ring-2 focus:ring-brand-green">
                </div>
                <div>
                    <label class="block text-body-sm font-medium text-slate-text mb-8">Số ghế</label>
                    <input type="number" name="seat_count" value="{{ old('seat_count', $schedule->seat_count) }}" min="1"
                        class="w-full px-16 py-12 border border-input-border rounded-md text-body focus:outline-none focus:ring-2 focus:ring-brand-green">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-24 mb-24">
                <div>
                    <label class="block text-body-sm font-medium text-slate-text mb-8">Giá vé <span class="text-red-500">*</span></label>
                    <input type="number" name="price" value="{{ old('price', $schedule->price) }}" required min="0" step="1000"
                        class="w-full px-16 py-12 border border-input-border rounded-md text-body focus:outline-none focus:ring-2 focus:ring-brand-green">
                </div>
                <div>
                    <label class="block text-body-sm font-medium text-slate-text mb-8">Thứ tự</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $schedule->sort_order) }}" min="0"
                        class="w-full px-16 py-12 border border-input-border rounded-md text-body focus:outline-none focus:ring-2 focus:ring-brand-green">
                </div>
            </div>
            <div>
                <label class="flex items-center">
                    <input type="checkbox" name="status" value="1" {{ old('status', $schedule->status) ? 'checked' : '' }} class="w-16 h-16 text-brand-green border-input-border rounded">
                    <span class="ml-8 text-body-sm text-slate-text">Kích hoạt lịch trình</span>
                </label>
            </div>
        </div>
        <div class="flex gap-12">
            <button type="submit" class="bg-brand-green text-canvas-white font-semibold py-14 px-28 rounded-md hover:bg-green-hover">Cập nhật</button>
            <a href="{{ route('admin.schedules.index') }}" class="bg-canvas-white text-muted-gray border border-input-border font-semibold py-14 px-28 rounded-md hover:bg-ghost-fog">Hủy</a>
        </div>
    </form>
</div>
@endsection
