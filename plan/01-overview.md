# Tổng quan dự án Website bán vé xe thiên về tin tức và thông tin

## 1. Mục tiêu

Dự án xây dựng một website bằng Laravel cho nhà xe hoặc đơn vị bán vé xe. Website tập trung vào nội dung, tin tức, tuyến xe, lịch trình tham khảo, hướng dẫn đặt vé và điều hướng người dùng sang form đặt vé của bên thứ ba.

Hệ thống không trực tiếp xử lý chọn ghế, thanh toán, giữ vé hoặc quản lý booking realtime vì các phần này đã được xử lý bởi tool đặt vé bên thứ ba.

## 2. Mô hình tổng thể

```text
Website Laravel = CMS + Trang thông tin + Tin tức + Tuyến xe + SEO
Tool bên thứ ba = Form đặt vé + Chọn ghế + Thanh toán + Quản lý booking
Admin Laravel = Quản lý nội dung, banner, tuyến xe, lịch trình, cài đặt website
```

## 3. Đối tượng sử dụng

### Khách hàng

- Xem thông tin nhà xe.
- Xem tuyến xe.
- Xem lịch trình tham khảo.
- Đọc tin tức và khuyến mãi.
- Xem hướng dẫn đặt vé.
- Bấm nút đặt vé để chuyển sang tool bên thứ ba.

### Admin

- Quản lý banner.
- Quản lý bài viết.
- Quản lý danh mục tin tức.
- Quản lý tuyến xe.
- Quản lý lịch trình tham khảo.
- Quản lý điểm đón/trả.
- Quản lý trang tĩnh.
- Quản lý FAQ.
- Cấu hình thông tin website.

## 4. Phạm vi không làm trong hệ thống Laravel

- Không tự chọn ghế.
- Không giữ ghế.
- Không xử lý thanh toán.
- Không tạo mã vé.
- Không quản lý vé realtime.
- Không quản lý hoàn/hủy vé trực tiếp.

Các nghiệp vụ trên sẽ nằm trong hệ thống của bên thứ ba.

## 5. Công nghệ đề xuất

- Laravel 12/13
- PostgreSQL
- Laravel Blade
- Tailwind CSS
- Filament Admin Panel
- Spatie Laravel Permission
- Spatie Media Library
- Spatie Sluggable
- Laravel Queue nếu cần gửi email liên hệ hoặc thông báo
