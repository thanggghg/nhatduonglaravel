# Phase 4: Tích hợp Tool Đặt vé bên thứ ba

**Mục tiêu:** Khách bấm đặt vé sẽ được chuyển sang form đặt vé

**Timeline:** 2-3 ngày

## Tasks

### 4.1 Configure Booking Tool

#### Environment Setup
- [ ] Thêm `BOOKING_TOOL_URL` vào `.env`
- [ ] Thêm config trong `config/services.php`

```php
'booking_tool' => [
    'url' => env('BOOKING_TOOL_URL', 'https://booking-tool.example.com'),
],
```

#### Settings Admin
- [ ] Thêm field "Link đặt vé mặc định" trong SettingResource
- [ ] Cho phép admin cấu hình link từ admin panel
- [ ] Hiển thị hướng dẫn sử dụng link

### 4.2 Create BookingRedirectController

- [ ] Tạo controller nếu chưa có
- [ ] Method `redirect(Request $request)`:
  - Lấy booking_url từ request hoặc config
  - Lấy route_id từ request
  - Lấy source_page từ request
  - Ghi log vào bảng booking_click_logs
  - Redirect sang URL tool bên thứ ba

**Example Code:**
```php
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
```

### 4.3 Add Booking Buttons

**Design theo DESIGN.md - Primary Button Style:**

#### Homepage
- [ ] Thêm nút "Đặt vé ngay" trong hero banner
- [ ] Link đến `/booking-redirect?source_page=home`
- [ ] **Style theo DESIGN.md:**
  - Background: #0b7f42 (brand green)
  - Text: #ffffff (white)
  - Border radius: 8px
  - Padding: 14px vertical, 28px horizontal
  - Font: Inter, 16px, weight 600
  - Hover: #096b39 (green-hover)

#### Header
- [ ] Thêm nút "Đặt vé" trên menu desktop
- [ ] Nổi bật với màu brand green (sticky header)
- [ ] Link đến `/booking-redirect?source_page=header`
- [ ] Style: Primary button theo DESIGN.md

#### Route Index Page
- [ ] Thêm nút "Đặt vé" cho mỗi tuyến xe trong card
- [ ] Link: `/booking-redirect?route_id={id}&source_page=route_index`
- [ ] Style: Primary button, size smaller cho cards

#### Route Detail Page
- [ ] Thêm nút "Đặt vé tuyến này" nổi bật
- [ ] Sticky button trên mobile (green primary)
- [ ] Link: `/booking-redirect?route_id={id}&source_page=route_detail`
- [ ] Nếu route có booking_url riêng, dùng URL đó

#### Post Detail Page
- [ ] Thêm CTA "Đặt vé ngay" ở cuối bài viết
- [ ] Link: `/booking-redirect?source_page=post_{slug}`
- [ ] Style: Primary green button

#### Floating Buttons (Mobile)
- [ ] Tạo floating action buttons ở bottom mobile
- [ ] 3 buttons: Gọi hotline | Zalo | Đặt vé
- [ ] Fixed position, z-index cao
- [ ] Icons + text
- [ ] **Đặt vé button: Primary green style theo DESIGN.md**
- [ ] Shadow: xl (green-tinted)

### 4.4 Tracking Implementation

#### BookingClickLog Model
- [ ] Thiết lập relationship với Route
- [ ] Thêm scope để filter theo date range
- [ ] Thêm accessor để format created_at

#### Admin Dashboard Widget
- [ ] Widget "Tổng lượt click đặt vé"
- [ ] Widget "Top 5 tuyến được quan tâm nhất"
- [ ] Chart theo ngày/tuần/tháng

#### BookingClickLogResource
- [ ] Table hiển thị: route, source_page, ip, created_at
- [ ] Filter theo route, source_page, date
- [ ] Export to Excel (optional)
- [ ] Không cho edit/delete

### 4.5 Alternative Integration Methods

#### Iframe Integration (Optional)
- [ ] Tạo route `/dat-ve-iframe`
- [ ] Tạo view với iframe embed
- [ ] Test X-Frame-Options compatibility
- [ ] Fallback về redirect nếu iframe bị block

#### Search Form Integration (Optional)
- [ ] Tạo form tìm tuyến: điểm đi, điểm đến, ngày đi
- [ ] Submit form gọi BookingRedirectController
- [ ] Truyền parameters vào booking_url nếu tool hỗ trợ
- [ ] Example: `?from=hcm&to=dalat&date=2026-05-28`

### 4.6 Testing

- [ ] Test redirect từ trang chủ
- [ ] Test redirect từ trang tuyến xe
- [ ] Test redirect từ mobile
- [ ] Test log được ghi đúng vào database
- [ ] Test với route có custom booking_url
- [ ] Test với route không có custom booking_url
- [ ] Test trên các browsers khác nhau
- [ ] Test nút floating buttons trên mobile

### 4.7 Documentation

- [ ] Tạo guide cho admin cách cấu hình booking URL
- [ ] Tạo guide cho admin cách xem tracking
- [ ] Document API parameters nếu cần custom integration

## Acceptance Criteria

- [ ] Khách bấm "Đặt vé" được redirect đúng
- [ ] Log ghi nhận đầy đủ: route_id, source_page, ip, user_agent
- [ ] Admin xem được thống kê lượt click trong dashboard
- [ ] Admin xem được chi tiết logs trong BookingClickLogResource
- [ ] Nút đặt vé hiển thị nhất quán trên tất cả trang
- [ ] **Button style tuân theo DESIGN.md:**
  - [ ] Primary green (#0b7f42) với white text
  - [ ] Border radius 8px
  - [ ] Hover state green-hover (#096b39)
  - [ ] Proper spacing và padding
- [ ] Floating buttons hoạt động tốt trên mobile
- [ ] Không có lỗi 404 hoặc broken links

## Notes

- **Tham khảo DESIGN.md cho button styles**
- Đảm bảo URL booking tool bên thứ ba đã được cung cấp
- Test kỹ trên mobile vì đây là platform chính
- Có thể thêm UTM parameters để tracking tốt hơn
- Cân nhắc thêm Google Analytics event tracking
- Primary action buttons phải dùng brand green
- Secondary actions (nếu có) dùng brand gold
