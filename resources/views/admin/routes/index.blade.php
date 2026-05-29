@extends('admin.layouts.app')

@section('title', 'Quản lý Tuyến xe')
@section('page-title', 'Tuyến xe')

@section('content')
<div class="mb-24 flex justify-between items-center">
    <p class="text-body text-muted-gray">Quản lý tất cả tuyến xe</p>
    <a href="{{ route('admin.routes.create') }}" class="bg-brand-green text-canvas-white font-semibold py-12 px-24 rounded-md hover:bg-green-hover">
        + Thêm tuyến xe
    </a>
</div>

<div class="bg-canvas-white rounded-lg shadow-md overflow-hidden">
    <table class="w-full">
        <thead class="bg-ghost-fog">
            <tr>
                <th class="px-24 py-16 text-left text-body-sm font-semibold text-forest-deep">Tên tuyến</th>
                <th class="px-24 py-16 text-left text-body-sm font-semibold text-forest-deep">Điểm đi - Điểm đến</th>
                <th class="px-24 py-16 text-left text-body-sm font-semibold text-forest-deep">Khoảng cách</th>
                <th class="px-24 py-16 text-left text-body-sm font-semibold text-forest-deep">Giá từ</th>
                <th class="px-24 py-16 text-left text-body-sm font-semibold text-forest-deep">Trạng thái</th>
                <th class="px-24 py-16 text-left text-body-sm font-semibold text-forest-deep">Thao tác</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-input-border">
            @forelse($routes as $route)
                <tr class="hover:bg-ghost-fog">
                    <td class="px-24 py-16 text-body text-slate-text font-medium">
                        {{ $route->name }}
                    </td>
                    <td class="px-24 py-16 text-body-sm text-muted-gray">
                        {{ $route->from_location }} → {{ $route->to_location }}
                    </td>
                    <td class="px-24 py-16 text-body-sm text-muted-gray">
                        {{ $route->distance ?? 'N/A' }}
                    </td>
                    <td class="px-24 py-16 text-body font-medium text-brand-green">
                        {{ number_format($route->price_from) }}đ
                    </td>
                    <td class="px-24 py-16">
                        @if($route->status)
                            <span class="inline-flex items-center px-12 py-4 rounded-full text-caption font-semibold bg-soft-green-background text-success-green-text">
                                Hoạt động
                            </span>
                        @else
                            <span class="inline-flex items-center px-12 py-4 rounded-full text-caption font-semibold bg-gray-100 text-gray-600">
                                Tắt
                            </span>
                        @endif
                    </td>
                    <td class="px-24 py-16 text-body-sm">
                        <div class="flex items-center gap-12">
                            <a href="{{ route('admin.routes.edit', $route->id) }}" class="text-brand-green hover:text-green-hover">
                                Sửa
                            </a>
                            <form method="POST" action="{{ route('admin.routes.destroy', $route->id) }}" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-700">
                                    Xóa
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-24 py-32 text-center text-body text-muted-gray">
                        Chưa có tuyến xe nào. <a href="{{ route('admin.routes.create') }}" class="text-brand-green hover:underline">Tạo tuyến xe mới</a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($routes->hasPages())
    <div class="mt-24">
        {{ $routes->links() }}
    </div>
@endif
@endsection
