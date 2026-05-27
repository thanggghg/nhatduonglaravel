# Phase 2: Xây CMS Admin

**Mục tiêu:** Admin có thể nhập dữ liệu nội dung

**Timeline:** 3-5 ngày

## Tasks

### 2.1 Create Models & Migrations

#### Banner
- [ ] `php artisan make:model Banner -m`
- [ ] Tạo migration với các trường: title, subtitle, image, button_text, button_url, position, sort_order, status
- [ ] Chạy migration

#### Post & PostCategory
- [ ] `php artisan make:model PostCategory -m`
- [ ] `php artisan make:model Post -m`
- [ ] Tạo migration với các trường theo database design
- [ ] Thiết lập relationship giữa Post và PostCategory

#### Route
- [ ] `php artisan make:model Route -m`
- [ ] Tạo migration với các trường: name, slug, from_location, to_location, distance, estimated_time, price_from, image, description, booking_url, status

#### Schedule
- [ ] `php artisan make:model Schedule -m`
- [ ] Tạo migration với các trường: route_id, departure_time, arrival_time, bus_type, price, note, sort_order, status
- [ ] Thiết lập foreign key với routes

#### Pickup & Dropoff Points
- [ ] `php artisan make:model PickupPoint -m`
- [ ] `php artisan make:model DropoffPoint -m`
- [ ] Tạo migration với các trường: route_id, name, address, map_url, phone, note, sort_order, status

#### Page & FAQ
- [ ] `php artisan make:model Page -m`
- [ ] `php artisan make:model Faq -m`
- [ ] Tạo migration theo database design

#### Contact
- [ ] `php artisan make:model Contact -m`
- [ ] Tạo migration với các trường: name, phone, email, message, status

#### BookingClickLog
- [ ] `php artisan make:model BookingClickLog -m`
- [ ] Tạo migration với các trường: route_id, source_page, booking_url, ip_address, user_agent

#### Run All Migrations
- [ ] `php artisan migrate`
- [ ] Kiểm tra tất cả bảng đã tạo thành công

### 2.2 Create Filament Resources

#### BannerResource
- [ ] `php artisan make:filament-resource Banner`
- [ ] Tạo form fields: TextInput, Textarea, FileUpload, Select, Toggle
- [ ] Tạo table columns
- [ ] Thêm filter cho status và position
- [ ] Thêm sort order

#### PostCategoryResource
- [ ] `php artisan make:filament-resource PostCategory`
- [ ] Tạo form fields: name, slug, description, status
- [ ] Auto-generate slug từ name

#### PostResource
- [ ] `php artisan make:filament-resource Post`
- [ ] Tạo form fields: category, title, slug, thumbnail, summary, content (RichEditor)
- [ ] Thêm SEO fields: meta_title, meta_description
- [ ] Thêm DateTimePicker cho published_at
- [ ] Tạo filter cho category và status

#### RouteResource
- [ ] `php artisan make:filament-resource Route`
- [ ] Tạo form fields đầy đủ theo plan
- [ ] Thêm relationship với schedules, pickup_points, dropoff_points
- [ ] Thêm repeater cho điểm đón/trả ngay trong form route

#### ScheduleResource
- [ ] `php artisan make:filament-resource Schedule`
- [ ] Tạo form fields: route (Select), departure_time, arrival_time, bus_type, price
- [ ] Thêm filter theo route

#### PageResource
- [ ] `php artisan make:filament-resource Page`
- [ ] Tạo form fields: title, slug, content (RichEditor), meta_title, meta_description
- [ ] Auto-generate slug

#### FaqResource
- [ ] `php artisan make:filament-resource Faq`
- [ ] Tạo form fields: question, answer, sort_order, status
- [ ] Thêm reorder functionality

#### ContactResource
- [ ] `php artisan make:filament-resource Contact`
- [ ] Tạo table columns để xem danh sách liên hệ
- [ ] Thêm filter theo status
- [ ] Thêm action để đánh dấu đã xử lý

#### SettingResource
- [ ] Tạo Settings model hoặc dùng Filament Settings plugin
- [ ] Tạo form cho: site_name, logo, favicon, hotline, email, address, social_links, booking_url, scripts

#### BookingClickLogResource
- [ ] `php artisan make:filament-resource BookingClickLog`
- [ ] Chỉ cho phếp xem (read-only)
- [ ] Thêm filter theo route và date range
- [ ] Thêm widget thống kê

### 2.3 Setup Dashboard
- [ ] Tạo widget thống kê tổng số posts
- [ ] Tạo widget thống kê tổng số routes
- [ ] Tạo widget thống kê tổng booking clicks
- [ ] Tạo widget hiển thị contacts mới
- [ ] Tạo chart cho booking clicks theo thời gian

### 2.4 Configure Permissions (Optional)
- [ ] Setup Spatie Permission
- [ ] Tạo roles: Super Admin, Admin, Editor
- [ ] Phân quyền cho từng resource

## Acceptance Criteria

- [ ] Admin có thể tạo/sửa/xóa banners
- [ ] Admin có thể tạo/sửa/xóa bài viết và danh mục
- [ ] Admin có thể tạo/sửa/xóa tuyến xe
- [ ] Admin có thể tạo/sửa/xóa lịch trình
- [ ] Admin có thể quản lý điểm đón/trả
- [ ] Admin có thể quản lý trang tĩnh và FAQ
- [ ] Admin có thể xem danh sách liên hệ
- [ ] Admin có thể cấu hình thông tin website
- [ ] Dashboard hiển thị thống kê cơ bản
- [ ] Tất cả form validation hoạt động đúng

## Notes

- Sử dụng Filament v3 features như Forms, Tables, Actions
- Áp dụng màu brand (#0b7f42, #fbb116) trong admin panel nếu có thể customize
- Test kỹ upload ảnh và rich editor
