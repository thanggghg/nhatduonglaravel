@extends('admin.layouts.app')
@section('title', 'Thêm lịch trình')
@section('page-title', 'Thêm lịch trình mới')
@section('content')
<div class="max-w-2xl">
    <form method="POST" action="{{ route('admin.schedules.store') }}">
        @csrf
        <div class="bg-canvas-white rounded-lg shadow-md p-32 mb-24">
            <div class="mb-24">
                <label class="block text-body-sm font-medium text-slate-text mb-8">Tuyến xe <span class="text-red-500">*</span></label>
                <select name="route_id" required class="w-full px-16 py-12 border border-input-border rounded-md text-body focus:outline-none focus:ring-2 focus:ring-brand-green @error('route_id') border-red-500 @enderror">
                    <option value="">-- Chọn tuyến xe --</option>
                    @foreach($routes as $route)
                        <option value="{{ $route->id }}" {{ old('route_id') == $route->id ? 'selected' : '' }}>{{ $route->name }}</option>
                    @endforeach
                </select>
                @error('route_id')<p class="mt-4 text-body-sm text-red-500">{{ $message }}</p>@enderror
            </div>
            <div class="grid grid-cols-2 gap-24 mb-24">
                <div>
                    <label class="block text-body-sm font-medium text-slate-text mb-8">Giờ khởi hành <span class="text-red-500">*</span></label>
                    <input type="time" name="departure_time" value="{{ old('departure_time') }}" required
                        class="w-full px-16 py-12 border border-input-border rounded-md text-body focus:outline-none focus:ring-2 focus:ring-brand-green @error('departure_time') border-red-500 @enderror">
                    @error('departure_time')<p class="mt-4 text-body-sm text-red-500">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-body-sm font-medium text-slate-text mb-8">Giờ đến</label>
                    <input type="time" name="arrival_time" value="{{ old('arrival_time') }}"
                        class="w-full px-16 py-12 border border-input-border rounded-md text-body focus:outline-none focus:ring-2 focus:ring-brand-green">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-24 mb-24">
                <div>
                    <label class="block text-body-sm font-medium text-slate-text mb-8">Loại xe</label>
                    <input type="text" name="vehicle_type" value="{{ old('vehicle_type') }}"
                        class="w-full px-16 py-12 border border-input-border rounded-md text-body focus:outline-none focus:ring-2 focus:ring-brand-green"
                        placeholder="VD: Giường nằm 40 chỗ">
                </div>
                <div>
                    <label class="block text-body-sm font-medium text-slate-text mb-8">Số ghế</label>
                    <input type="number" name="seat_count" value="{{ old('seat_count') }}" min="1"
                        class="w-full px-16 py-12 border border-input-border rounded-md text-body focus:outline-none focus:ring-2 focus:ring-brand-green">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-24 mb-24">
                <div>
                    <label class="block text-body-sm font-medium text-slate-text mb-8">Giá vé <span class="text-red-500">*</span></label>
                    <input type="number" name="price" value="{{ old('price') }}" required min="0" step="1000"
                        class="w-full px-16 py-12 border border-input-border rounded-md text-body focus:outline-none focus:ring-2 focus:ring-brand-green @error('price') border-red-500 @enderror"
                        placeholder="350000">
                    @error('price')<p class="mt-4 text-body-sm text-red-500">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-body-sm font-medium text-slate-text mb-8">Thứ tự</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0"
                        class="w-full px-16 py-12 border border-input-border rounded-md text-body focus:outline-none focus:ring-2 focus:ring-brand-green">
                </div>
            </div>
            <div>
                <label class="flex items-center">
                    <input type="checkbox" name="status" value="1" {{ old('status', true) ? 'checked' : '' }} class="w-16 h-16 text-brand-green border-input-border rounded">
                    <span class="ml-8 text-body-sm text-slate-text">Kích hoạt lịch trình</span>
                </label>
            </div>
        </div>
        <div class="flex gap-12">
            <button type="submit" class="bg-brand-green text-canvas-white font-semibold py-14 px-28 rounded-md hover:bg-green-hover">Tạo lịch trình</button>
            <a href="{{ route('admin.schedules.index') }}" class="bg-canvas-white text-muted-gray border border-input-border font-semibold py-14 px-28 rounded-md hover:bg-ghost-fog">Hủy</a>
        </div>
    </form>
</div>
@endsection
