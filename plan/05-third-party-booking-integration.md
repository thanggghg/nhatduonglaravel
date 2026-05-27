# Tích hợp Tool đặt vé bên thứ ba

## 1. Nguyên tắc tích hợp

Website Laravel không xử lý booking trực tiếp. Khi khách hàng muốn đặt vé, website sẽ chuyển khách sang tool đặt vé bên thứ ba hoặc nhúng form đặt vé nếu tool đó hỗ trợ iframe.

## 2. Cách 1: Redirect sang tool đặt vé

Đây là cách đơn giản và ổn định nhất.

Luồng xử lý:

```text
Khách vào website
Khách bấm Đặt vé
Laravel ghi log lượt click
Laravel redirect sang URL của tool bên thứ ba
Khách hoàn tất đặt vé bên ngoài
```

Ví dụ route:

```php
Route::get('/booking-redirect', [BookingRedirectController::class, 'redirect'])
    ->name('booking.redirect');
```

Ví dụ controller:

```php
class BookingRedirectController extends Controller
{
    public function redirect(Request $request)
    {
        $bookingUrl = $request->booking_url ?: config('services.booking_tool.url');

        BookingClickLog::create([
            'route_id' => $request->route_id,
            'source_page' => $request->source_page,
            'booking_url' => $bookingUrl,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->away($bookingUrl);
    }
}
```

## 3. Cách 2: Nhúng iframe

Chỉ dùng khi tool bên thứ ba cho phép nhúng iframe.

```html
<iframe
    src="https://booking-tool.example.com/company/demo"
    width="100%"
    height="900"
    frameborder="0"
    loading="lazy">
</iframe>
```

Ưu điểm:

```text
- Khách vẫn ở trong website chính.
- Trải nghiệm liền mạch hơn.
```

Nhược điểm:

```text
- Có thể bị chặn bởi X-Frame-Options hoặc Content-Security-Policy.
- Giao diện mobile có thể không đẹp.
- Khó tracking sâu bên trong form.
```

## 4. Cách 3: Form tìm kiếm đơn giản rồi redirect

Website có form:

```text
Điểm đi
Điểm đến
Ngày đi
```

Sau khi submit, Laravel redirect sang tool bên thứ ba kèm tham số nếu tool hỗ trợ.

Ví dụ:

```text
/booking-redirect?from=hcm&to=dalat&date=2026-05-28
```

Redirect sang:

```text
https://booking-tool.example.com/search?from=hcm&to=dalat&date=2026-05-28
```

## 5. Cấu hình trong .env

```env
BOOKING_TOOL_URL=https://booking-tool.example.com/company/demo
```

Trong `config/services.php`:

```php
'booking_tool' => [
    'url' => env('BOOKING_TOOL_URL'),
],
```

## 6. Tracking lượt click đặt vé

Mục tiêu tracking:

```text
- Biết khách bấm đặt vé từ trang nào.
- Biết tuyến nào được quan tâm nhiều nhất.
- Biết banner nào hiệu quả nhất.
```

Dữ liệu cần lưu:

```text
route_id
source_page
booking_url
ip_address
user_agent
created_at
```
