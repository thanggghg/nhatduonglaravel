# Lộ trình triển khai dự án

## Giai đoạn 1: Khởi tạo dự án

Mục tiêu: Có source Laravel chạy được và admin cơ bản.

Checklist:

```text
- Tạo project Laravel
- Cấu hình database
- Cài Laravel Breeze hoặc auth mặc định của Filament
- Cài Filament Admin
- Cài Spatie Permission nếu cần phân quyền chi tiết
- Cấu hình layout frontend
- Cấu hình storage link
```

Lệnh tham khảo:

```bash
composer create-project laravel/laravel bus-news-booking
cd bus-news-booking
php artisan storage:link
```

## Giai đoạn 2: Xây CMS admin

Mục tiêu: Admin có thể nhập dữ liệu nội dung.

Module cần làm:

```text
- Banner
- Danh mục tin tức
- Bài viết
- Tuyến xe
- Lịch trình
- Điểm đón
- Điểm trả
- Trang tĩnh
- FAQ
- Cấu hình website
```

## Giai đoạn 3: Xây giao diện frontend

Mục tiêu: Khách hàng xem được nội dung website.

Trang cần làm:

```text
- Trang chủ
- Trang giới thiệu
- Trang tuyến xe
- Trang chi tiết tuyến xe
- Trang lịch trình
- Trang tin tức
- Trang chi tiết tin tức
- Trang hướng dẫn đặt vé
- Trang liên hệ
```

## Giai đoạn 4: Tích hợp tool đặt vé bên thứ ba

Mục tiêu: Khách bấm đặt vé sẽ được chuyển sang form đặt vé.

Việc cần làm:

```text
- Cấu hình URL tool đặt vé mặc định
- Thêm link đặt vé riêng cho từng tuyến
- Tạo BookingRedirectController
- Ghi log click đặt vé
- Thêm nút đặt vé ở header, banner, trang tuyến, bài viết
- Kiểm tra redirect trên mobile
```

## Giai đoạn 5: SEO và tracking

Mục tiêu: Tối ưu hiển thị Google và đo lường hiệu quả.

Việc cần làm:

```text
- Meta title cho trang chủ
- Meta description cho trang chủ
- Meta cho bài viết
- Meta cho tuyến xe
- Sitemap XML
- Robots.txt
- Google Analytics
- Facebook Pixel nếu cần
- Tối ưu tốc độ tải ảnh
```

## Giai đoạn 6: Kiểm thử và deploy

Checklist kiểm thử:

```text
- Website responsive trên mobile
- Menu hoạt động đúng
- Link đặt vé hoạt động đúng
- Form liên hệ gửi được
- Admin đăng nhập được
- Admin tạo/sửa/xóa nội dung được
- SEO title/description hiển thị đúng
- Không lỗi 404 với slug
- Không lỗi ảnh bị mất
```

Checklist deploy:

```text
- Cấu hình .env production
- Chạy migration
- Chạy storage link
- Cấu hình queue nếu có
- Cấu hình cache config
- Cấu hình web server Nginx/Apache
- Cấu hình SSL
- Backup database
```
