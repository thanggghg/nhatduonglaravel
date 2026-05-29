# Phase 3: Xây Giao diện Frontend

**Mục tiêu:** Khách hàng xem được nội dung website

**Timeline:** 5-7 ngày

**Design Reference:** Tất cả thiết kế phải tuân theo DESIGN.md

## Design System Requirements

Trước khi bắt đầu, đảm bảo nắm vững Design System:
- **Colors:** Brand Green (#0b7f42), Brand Gold (#fbb116)
- **Typography:** Inter font, weights 400-700
- **Spacing:** Base unit 8px, Section gap 64px, Element gap 24px
- **Border Radius:** 8px (buttons/inputs), 16px (cards), 999px (badges)
- **Shadows:** Green-tinted rgba(11, 127, 66, 0.10)
- **Layout:** Max-width 1200px, centered

## Tasks

### 3.1 Setup Routes

- [x] Tạo route cho trang chủ: `/`
- [x] Tạo route cho tin tức: `/tin-tuc`, `/tin-tuc/{slug}`
- [x] Tạo route cho tuyến xe: `/tuyen-xe`, `/tuyen-xe/{slug}`
- [x] Tạo route cho lịch trình: `/lich-trinh`
- [x] Tạo route cho liên hệ: `/lien-he` (GET + POST)
- [x] Tạo route cho booking redirect: `/dat-ve`, `/booking-redirect`
- [x] Tạo route cho trang tĩnh: `/{slug}`

**File:** `routes/web.php`

### 3.2 Create Controllers

#### HomeController
- [x] `php artisan make:controller HomeController`
- [x] Method `index()`: lấy banners, featured routes, latest posts, schedules
- [x] Pass data sang view `home.blade.php`

#### PostController
- [x] `php artisan make:controller PostController`
- [x] Method `index()`: danh sách bài viết có phân trang
- [x] Method `show($slug)`: chi tiết bài viết
- [x] Lấy related posts

#### RouteController
- [x] `php artisan make:controller RouteController`
- [x] Method `index()`: danh sách tuyến xe
- [x] Method `show($slug)`: chi tiết tuyến xe kèm schedules, pickup/dropoff points
- [x] Hiển thị FAQs liên quan

#### ScheduleController
- [x] `php artisan make:controller ScheduleController`
- [x] Method `index()`: bảng lịch trình tham khảo

#### PageController
- [x] `php artisan make:controller PageController`
- [x] Method `show($slug)`: hiển thị trang tĩnh

#### ContactController
- [x] `php artisan make:controller ContactController`
- [x] Method `index()`: hiển thị trang liên hệ
- [x] Method `store()`: xử lý form liên hệ
- [x] Validation form
- [x] Lưu vào database
- [ ] Gửi email thông báo (optional)

#### BookingRedirectController
- [x] `php artisan make:controller BookingRedirectController`
- [x] Method `index()`: hiển thị trang đặt vé (optional)
- [x] Method `redirect()`: ghi log và redirect sang tool bên thứ ba

### 3.3 Create Views

#### Layout
- [x] `resources/views/layouts/app.blade.php`: layout chính
- [x] `resources/views/layouts/header.blade.php`: header + navigation
- [x] `resources/views/layouts/footer.blade.php`: footer + links
- [x] **Áp dụng Design System theo DESIGN.md:**
  - [x] Brand colors: Green (#0b7f42), Gold (#fbb116)
  - [x] Inter font family
  - [x] Max-width 1200px container
  - [x] Sticky header với brand green button
  - [x] Section spacing 64px

#### Home
- [x] `resources/views/home.blade.php`
- [x] Section: Hero banner slider (với green gradient background)
- [x] Section: Form tìm tuyến hoặc nút đặt vé nổi bật (green button)
- [x] Section: Tuyến xe nổi bật (4-6 cards với 16px radius)
- [x] Section: Lịch trình phổ biến
- [x] Section: Tin tức mới nhất (3-4 bài)
- [x] Section: Khuyến mãi banner (gold accent)
- [x] Section: Hướng dẫn đặt vé (4 bước)
- [x] Section: Vì sao chọn chúng tôi (features với icons)
- [x] Section: Thông tin liên hệ
- [x] Sticky button: Gọi hotline | Zalo | Đặt vé (mobile) - green primary button

#### Posts
- [x] `resources/views/posts/index.blade.php`: danh sách bài viết
- [x] `resources/views/posts/show.blade.php`: chi tiết bài viết
- [x] Sidebar: danh mục, bài viết liên quan
- [x] Breadcrumb navigation
- [x] SEO meta tags

#### Routes
- [x] `resources/views/routes/index.blade.php`: danh sách tuyến xe
- [x] `resources/views/routes/show.blade.php`: chi tiết tuyến xe
- [x] Hiển thị: thông tin tuyến, lịch trình, điểm đón/trả, FAQs
- [x] Nút đặt vé nổi bật
- [x] Breadcrumb navigation
- [x] SEO meta tags

#### Schedules
- [x] `resources/views/schedules/index.blade.php`: bảng lịch trình
- [x] Table responsive
- [x] Filter theo tuyến

#### Pages
- [x] `resources/views/pages/show.blade.php`: trang tĩnh
- [x] Hỗ trợ rich content
- [x] Breadcrumb navigation

#### Contact
- [x] `resources/views/contact/index.blade.php`: trang liên hệ
- [x] Form: họ tên, phone, email, nội dung
- [x] Thông tin: hotline, zalo, email, địa chỉ
- [x] Embed Google Map
- [x] Form validation và success message

#### Booking
- [x] `resources/views/booking/index.blade.php`: trang hướng dẫn đặt vé
- [x] Hoặc chỉ có button redirect trực tiếp

### 3.4 Components (Optional)

**Design theo DESIGN.md components:**
- [ ] `resources/views/components/route-card.blade.php` (16px radius, elevated card style)
- [ ] `resources/views/components/post-card.blade.php` (16px radius, subtle background)
- [ ] `resources/views/components/schedule-table.blade.php` (responsive table)
- [ ] `resources/views/components/booking-button.blade.php` (green primary, 8px radius)
- [ ] `resources/views/components/badge.blade.php` (999px radius, success/promotional)

### 3.5 Styling với Tailwind CSS

**CRITICAL: Tất cả styling phải theo DESIGN.md**

- [ ] Cấu hình Tailwind với brand colors từ DESIGN.md
- [ ] Import Inter font từ Google Fonts
- [ ] Setup CSS variables từ DESIGN.md
- [ ] **Button Styles theo DESIGN.md:**
  - [ ] Primary: bg-brand-green (#0b7f42), text white, 8px radius, hover #096b39
  - [ ] Secondary: bg-brand-gold (#fbb116), text #8a6300, 8px radius, hover #e19f14
  - [ ] Outlined: border-2 border-brand-green, text green, 8px radius
  - [ ] Ghost: transparent, text muted-gray, hover green
- [ ] **Card Styles:**
  - [ ] Elevated: white bg, 16px radius, shadow-lg (green-tinted)
  - [ ] Subtle: ghost-fog bg (#f8fdf9), 12px radius, no shadow
- [ ] **Badge Styles:**
  - [ ] Success: soft-green-background (#e8f8ef), success-green-text, 999px radius
  - [ ] Promotional: light-gold (#fef3d7), gold-text, 999px radius
- [ ] **Input Styles:**
  - [ ] White bg, input-border (#d1ddd5), 8px radius
  - [ ] Focus: 2px solid brand-green
- [ ] **Typography Scale từ DESIGN.md:**
  - [ ] body: 16px, leading 1.5
  - [ ] heading: 28px, leading 1.2, tracking -0.56px
  - [ ] display: 72px, leading 1.05, tracking -1.44px
- [ ] **Spacing:**
  - [ ] Section gap: 64px
  - [ ] Element gap: 24px
  - [ ] Card padding: 32px
- [ ] CSS responsive cho mobile (mobile-first)
- [ ] CSS cho sticky header
- [ ] CSS cho floating buttons (mobile)

### 3.6 SEO Integration

- [x] Cài artesaos/seotools (installed v1.4)
- [x] Setup SEO meta tags trong layouts
- [x] Dynamic title và description cho từng trang
- [ ] Open Graph tags
- [ ] Twitter Card tags
- [ ] Structured data (Schema.org) cho routes

### 3.7 Assets & Images

**Design Guidelines từ DESIGN.md:**
- [ ] Tạo logo với màu brand green (#0b7f42) và gold (#fbb116)
- [ ] Tạo favicon
- [ ] Placeholder images cho tuyến xe (professional, natural lighting)
- [ ] Icons cho features section (duotone với green/gold accents)
- [ ] Optimize images (WebP format preferred)
- [ ] All images: professional, well-lit, convey trust and growth

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
- [ ] **Design System từ DESIGN.md được áp dụng nhất quán:**
  - [ ] Màu brand green/gold đúng hex codes
  - [ ] Inter font được sử dụng
  - [ ] Border radius: 8px (buttons), 16px (cards)
  - [ ] Shadows: green-tinted
  - [ ] Spacing: 64px sections, 24px elements
  - [ ] Typography scale đúng

## Notes

- **CRITICAL: Tham khảo DESIGN.md cho mọi quyết định về design**
- Ưu tiên mobile-first design
- Test trên nhiều devices và browsers
- Optimize performance (lazy loading images)
- Cân nhắc dùng Alpine.js cho interactive components
- Use Inter font family (download from Google Fonts)
- Green (#0b7f42) for trust/primary, Gold (#fbb116) for highlights/secondary
