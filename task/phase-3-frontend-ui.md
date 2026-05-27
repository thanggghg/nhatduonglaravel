# Phase 3: Xây Giao diện Frontend

**Mục tiêu:** Khách hàng xem được nội dung website

**Timeline:** 5-7 ngày

## Tasks

### 3.1 Setup Routes

- [ ] Tạo route cho trang chủ: `/`
- [ ] Tạo route cho tin tức: `/tin-tuc`, `/tin-tuc/{slug}`
- [ ] Tạo route cho tuyến xe: `/tuyen-xe`, `/tuyen-xe/{slug}`
- [ ] Tạo route cho lịch trình: `/lich-trinh`
- [ ] Tạo route cho liên hệ: `/lien-he` (GET + POST)
- [ ] Tạo route cho booking redirect: `/dat-ve`, `/booking-redirect`
- [ ] Tạo route cho trang tĩnh: `/{slug}`

**File:** `routes/web.php`

### 3.2 Create Controllers

#### HomeController
- [ ] `php artisan make:controller HomeController`
- [ ] Method `index()`: lấy banners, featured routes, latest posts, schedules
- [ ] Pass data sang view `home.blade.php`

#### PostController
- [ ] `php artisan make:controller PostController`
- [ ] Method `index()`: danh sách bài viết có phân trang
- [ ] Method `show($slug)`: chi tiết bài viết
- [ ] Lấy related posts

#### RouteController
- [ ] `php artisan make:controller RouteController`
- [ ] Method `index()`: danh sách tuyến xe
- [ ] Method `show($slug)`: chi tiết tuyến xe kèm schedules, pickup/dropoff points
- [ ] Hiển thị FAQs liên quan

#### ScheduleController
- [ ] `php artisan make:controller ScheduleController`
- [ ] Method `index()`: bảng lịch trình tham khảo

#### PageController
- [ ] `php artisan make:controller PageController`
- [ ] Method `show($slug)`: hiển thị trang tĩnh

#### ContactController
- [ ] `php artisan make:controller ContactController`
- [ ] Method `index()`: hiển thị trang liên hệ
- [ ] Method `store()`: xử lý form liên hệ
- [ ] Validation form
- [ ] Lưu vào database
- [ ] Gửi email thông báo (optional)

#### BookingRedirectController
- [ ] `php artisan make:controller BookingRedirectController`
- [ ] Method `index()`: hiển thị trang đặt vé (optional)
- [ ] Method `redirect()`: ghi log và redirect sang tool bên thứ ba

### 3.3 Create Views

#### Layout
- [ ] `resources/views/layouts/app.blade.php`: layout chính
- [ ] `resources/views/layouts/header.blade.php`: header + navigation
- [ ] `resources/views/layouts/footer.blade.php`: footer + links
- [ ] Áp dụng màu brand: #0b7f42 (green), #fbb116 (gold)

#### Home
- [ ] `resources/views/home.blade.php`
- [ ] Section: Hero banner slider
- [ ] Section: Form tìm tuyến hoặc nút đặt vé nổi bật
- [ ] Section: Tuyến xe nổi bật (4-6 cards)
- [ ] Section: Lịch trình phổ biến
- [ ] Section: Tin tức mới nhất (3-4 bài)
- [ ] Section: Khuyến mãi banner
- [ ] Section: Hướng dẫn đặt vé (4 bước)
- [ ] Section: Vì sao chọn chúng tôi (features)
- [ ] Section: Thông tin liên hệ
- [ ] Sticky button: Gọi hotline | Zalo | Đặt vé (mobile)

#### Posts
- [ ] `resources/views/posts/index.blade.php`: danh sách bài viết
- [ ] `resources/views/posts/show.blade.php`: chi tiết bài viết
- [ ] Sidebar: danh mục, bài viết liên quan
- [ ] Breadcrumb navigation
- [ ] SEO meta tags

#### Routes
- [ ] `resources/views/routes/index.blade.php`: danh sách tuyến xe
- [ ] `resources/views/routes/show.blade.php`: chi tiết tuyến xe
- [ ] Hiển thị: thông tin tuyến, lịch trình, điểm đón/trả, FAQs
- [ ] Nút đặt vé nổi bật
- [ ] Breadcrumb navigation
- [ ] SEO meta tags

#### Schedules
- [ ] `resources/views/schedules/index.blade.php`: bảng lịch trình
- [ ] Table responsive
- [ ] Filter theo tuyến

#### Pages
- [ ] `resources/views/pages/show.blade.php`: trang tĩnh
- [ ] Hỗ trợ rich content
- [ ] Breadcrumb navigation

#### Contact
- [ ] `resources/views/contact/index.blade.php`: trang liên hệ
- [ ] Form: họ tên, phone, email, nội dung
- [ ] Thông tin: hotline, zalo, email, địa chỉ
- [ ] Embed Google Map
- [ ] Form validation và success message

#### Booking
- [ ] `resources/views/booking/index.blade.php`: trang hướng dẫn đặt vé (optional)
- [ ] Hoặc chỉ có button redirect trực tiếp

### 3.4 Components (Optional)

- [ ] `resources/views/components/route-card.blade.php`
- [ ] `resources/views/components/post-card.blade.php`
- [ ] `resources/views/components/schedule-table.blade.php`
- [ ] `resources/views/components/booking-button.blade.php`

### 3.5 Styling

- [ ] Install Tailwind CSS hoặc Bootstrap
- [ ] Áp dụng DESIGN.md với màu brand #0b7f42 và #fbb116
- [ ] Setup font Inter hoặc font phù hợp
- [ ] CSS cho buttons: primary (green), secondary (gold)
- [ ] CSS cho cards với border radius 16px
- [ ] CSS cho badges với border radius 999px
- [ ] CSS responsive cho mobile
- [ ] CSS cho sticky header
- [ ] CSS cho floating buttons (mobile)

### 3.6 SEO Integration

- [ ] Cài artesaos/seotools
- [ ] Setup SEO meta tags trong layouts
- [ ] Dynamic title và description cho từng trang
- [ ] Open Graph tags
- [ ] Twitter Card tags
- [ ] Structured data (Schema.org) cho routes

### 3.7 Assets & Images

- [ ] Tạo logo với màu brand
- [ ] Tạo favicon
- [ ] Placeholder images cho tuyến xe
- [ ] Icons cho features section
- [ ] Optimize images

## Acceptance Criteria

- [ ] Trang chủ hiển thị đầy đủ sections theo plan
- [ ] Trang tuyến xe hiển thị danh sách và chi tiết
- [ ] Trang tin tức hiển thị danh sách và chi tiết
- [ ] Trang lịch trình hiển thị bảng lịch
- [ ] Trang liên hệ có form hoạt động
- [ ] Tất cả trang responsive trên mobile
- [ ] Navigation menu hoạt động đúng
- [ ] Breadcrumb hiển thị đúng
- [ ] SEO meta tags hiển thị đúng
- [ ] Màu brand được áp dụng nhất quán

## Notes

- Ưu tiên mobile-first design
- Test trên nhiều devices và browsers
- Optimize performance (lazy loading images)
- Cân nhắc dùng Alpine.js cho interactive components
