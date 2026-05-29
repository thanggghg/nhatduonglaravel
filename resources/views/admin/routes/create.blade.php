@extends('admin.layouts.app')

@section('title', 'Thêm tuyến xe mới')
@section('page-title', 'Thêm tuyến xe mới')

@section('content')
<div class="max-w-3xl">
    <form method="POST" action="{{ route('admin.routes.store') }}">
        @csrf

        <div class="bg-canvas-white rounded-lg shadow-md p-32 mb-24">
            <h3 class="text-heading font-semibold text-forest-deep mb-24">Thông tin tuyến xe</h3>

            <!-- Name -->
            <div class="mb-24">
                <label for="name" class="block text-body-sm font-medium text-slate-text mb-8">
                    Tên tuyến <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    value="{{ old('name') }}"
                    required
                    class="w-full px-16 py-12 border border-input-border rounded-md text-body text-slate-text placeholder-hint-gray focus:outline-none focus:ring-2 focus:ring-brand-green @error('name') border-red-500 @enderror"
                    placeholder="VD: Hà Nội - Đà Nẵng"
                >
                @error('name')
                    <p class="mt-4 text-body-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- From Location -->
            <div class="mb-24">
                <label for="from_location" class="block text-body-sm font-medium text-slate-text mb-8">
                    Điểm đi <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="from_location" 
                    name="from_location" 
                    value="{{ old('from_location') }}"
                    required
                    class="w-full px-16 py-12 border border-input-border rounded-md text-body text-slate-text placeholder-hint-gray focus:outline-none focus:ring-2 focus:ring-brand-green @error('from_location') border-red-500 @enderror"
                    placeholder="VD: Hà Nội"
                >
                @error('from_location')
                    <p class="mt-4 text-body-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- To Location -->
            <div class="mb-24">
                <label for="to_location" class="block text-body-sm font-medium text-slate-text mb-8">
                    Điểm đến <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="to_location" 
                    name="to_location" 
                    value="{{ old('to_location') }}"
                    required
                    class="w-full px-16 py-12 border border-input-border rounded-md text-body text-slate-text placeholder-hint-gray focus:outline-none focus:ring-2 focus:ring-brand-green @error('to_location') border-red-500 @enderror"
                    placeholder="VD: Đà Nẵng"
                >
                @error('to_location')
                    <p class="mt-4 text-body-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-24 mb-24">
                <!-- Distance -->
                <div>
                    <label for="distance" class="block text-body-sm font-medium text-slate-text mb-8">
                        Khoảng cách
                    </label>
                    <input 
                        type="text" 
                        id="distance" 
                        name="distance" 
                        value="{{ old('distance') }}"
                        class="w-full px-16 py-12 border border-input-border rounded-md text-body text-slate-text placeholder-hint-gray focus:outline-none focus:ring-2 focus:ring-brand-green"
                        placeholder="VD: 760 km"
                    >
                </div>

                <!-- Estimated Time -->
                <div>
                    <label for="estimated_time" class="block text-body-sm font-medium text-slate-text mb-8">
                        Thời gian ước tính
                    </label>
                    <input 
                        type="text" 
                        id="estimated_time" 
                        name="estimated_time" 
                        value="{{ old('estimated_time') }}"
                        class="w-full px-16 py-12 border border-input-border rounded-md text-body text-slate-text placeholder-hint-gray focus:outline-none focus:ring-2 focus:ring-brand-green"
                        placeholder="VD: 12 giờ"
                    >
                </div>
            </div>

            <!-- Price From -->
            <div class="mb-24">
                <label for="price_from" class="block text-body-sm font-medium text-slate-text mb-8">
                    Giá vé từ <span class="text-red-500">*</span>
                </label>
                <input 
                    type="number" 
                    id="price_from" 
                    name="price_from" 
                    value="{{ old('price_from') }}"
                    required
                    min="0"
                    step="1000"
                    class="w-full px-16 py-12 border border-input-border rounded-md text-body text-slate-text placeholder-hint-gray focus:outline-none focus:ring-2 focus:ring-brand-green @error('price_from') border-red-500 @enderror"
                    placeholder="VD: 350000"
                >
                @error('price_from')
                    <p class="mt-4 text-body-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="mb-24">
                <label for="description" class="block text-body-sm font-medium text-slate-text mb-8">
                    Mô tả
                </label>
                <textarea 
                    id="description" 
                    name="description" 
                    rows="4"
                    class="w-full px-16 py-12 border border-input-border rounded-md text-body text-slate-text placeholder-hint-gray focus:outline-none focus:ring-2 focus:ring-brand-green"
                    placeholder="Mô tả chi tiết về tuyến xe..."
                >{{ old('description') }}</textarea>
            </div>

            <!-- Booking URL -->
            <div class="mb-24">
                <label for="booking_url" class="block text-body-sm font-medium text-slate-text mb-8">
                    Link đặt vé
                </label>
                <input 
                    type="url" 
                    id="booking_url" 
                    name="booking_url" 
                    value="{{ old('booking_url') }}"
                    class="w-full px-16 py-12 border border-input-border rounded-md text-body text-slate-text placeholder-hint-gray focus:outline-none focus:ring-2 focus:ring-brand-green"
                    placeholder="https://..."
                >
            </div>

            <!-- Status -->
            <div>
                <label class="flex items-center">
                    <input 
                        type="checkbox" 
                        name="status" 
                        value="1"
                        {{ old('status', true) ? 'checked' : '' }}
                        class="w-16 h-16 text-brand-green border-input-border rounded focus:ring-2 focus:ring-brand-green"
                    >
                    <span class="ml-8 text-body-sm text-slate-text">Kích hoạt tuyến xe này</span>
                </label>
            </div>
        </div>

        <div class="flex gap-12">
            <button 
                type="submit"
                class="bg-brand-green text-canvas-white font-semibold py-14 px-28 rounded-md hover:bg-green-hover"
            >
                Tạo tuyến xe
            </button>
            <a 
                href="{{ route('admin.routes.index') }}"
                class="bg-canvas-white text-muted-gray border border-input-border font-semibold py-14 px-28 rounded-md hover:bg-ghost-fog"
            >
                Hủy
            </a>
        </div>
    </form>
</div>
@endsection
