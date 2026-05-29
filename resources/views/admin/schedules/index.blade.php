@extends('admin.layouts.app')
@section('title', 'Lịch trình')
@section('page-title', 'Lịch trình')
@section('content')
<div class="mb-24 flex justify-between items-center">
    <p class="text-body text-muted-gray">Quản lý lịch trình xe</p>
    <a href="{{ route('admin.schedules.create') }}" class="bg-brand-green text-canvas-white font-semibold py-12 px-24 rounded-md hover:bg-green-hover">+ Thêm lịch trình</a>
</div>
<div class="bg-canvas-white rounded-lg shadow-md overflow-hidden">
    <table class="w-full">
        <thead class="bg-ghost-fog">
            <tr>
                <th class="px-24 py-16 text-left text-body-sm font-semibold text-forest-deep">Tuyến xe</th>
                <th class="px-24 py-16 text-left text-body-sm font-semibold text-forest-deep">Giờ đi</th>
                <th class="px-24 py-16 text-left text-body-sm font-semibold text-forest-deep">Giờ đến</th>
                <th class="px-24 py-16 text-left text-body-sm font-semibold text-forest-deep">Loại xe</th>
                <th class="px-24 py-16 text-left text-body-sm font-semibold text-forest-deep">Giá</th>
                <th class="px-24 py-16 text-left text-body-sm font-semibold text-forest-deep">Trạng thái</th>
                <th class="px-24 py-16 text-left text-body-sm font-semibold text-forest-deep">Thao tác</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-input-border">
            @forelse($schedules as $schedule)
            <tr class="hover:bg-ghost-fog">
                <td class="px-24 py-16 text-body font-medium text-slate-text">{{ $schedule->route->name ?? '—' }}</td>
                <td class="px-24 py-16 text-body-sm text-muted-gray">{{ $schedule->departure_time ? \Carbon\Carbon::parse($schedule->departure_time)->format('H:i') : '—' }}</td>
                <td class="px-24 py-16 text-body-sm text-muted-gray">{{ $schedule->arrival_time ? \Carbon\Carbon::parse($schedule->arrival_time)->format('H:i') : '—' }}</td>
                <td class="px-24 py-16 text-body-sm text-muted-gray">{{ $schedule->vehicle_type ?? '—' }}</td>
                <td class="px-24 py-16 text-body font-medium text-brand-green">{{ number_format($schedule->price) }}đ</td>
                <td class="px-24 py-16">
                    @if($schedule->status)
                        <span class="inline-flex px-12 py-4 rounded-full text-caption font-semibold bg-soft-green-background text-success-green-text">Hoạt động</span>
                    @else
                        <span class="inline-flex px-12 py-4 rounded-full text-caption font-semibold bg-gray-100 text-gray-600">Tắt</span>
                    @endif
                </td>
                <td class="px-24 py-16 text-body-sm">
                    <div class="flex items-center gap-12">
                        <a href="{{ route('admin.schedules.edit', $schedule->id) }}" class="text-brand-green hover:text-green-hover">Sửa</a>
                        <form method="POST" action="{{ route('admin.schedules.destroy', $schedule->id) }}" onsubmit="return confirm('Xóa lịch trình này?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-700">Xóa</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="px-24 py-32 text-center text-body text-muted-gray">Chưa có lịch trình nào.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@if($schedules->hasPages())<div class="mt-24">{{ $schedules->links() }}</div>@endif
@endsection
