# Thiết kế Admin CMS bằng Laravel Filament

## 1. Mục tiêu admin

Admin dùng để quản lý nội dung website, không quản lý booking realtime. Phần đặt vé, chọn ghế và thanh toán sẽ được xử lý bởi tool bên thứ ba.

## 2. Các module admin

```text
Dashboard
Banner
Danh mục tin tức
Bài viết
Tuyến xe
Lịch trình
Điểm đón/trả
Trang tĩnh
FAQ
Liên hệ
Cấu hình website
Tracking click đặt vé
Người dùng và phân quyền
```

## 3. Dashboard

Dashboard nên hiển thị:

```text
- Tổng số bài viết
- Tổng số tuyến xe
- Tổng số banner đang hoạt động
- Tổng số liên hệ mới
- Tổng lượt click đặt vé
- Tuyến có nhiều lượt click đặt vé nhất
- Bài viết mới nhất
```

## 4. Banner Resource

Trường dữ liệu:

```text
- Tiêu đề
- Mô tả ngắn
- Ảnh banner
- Text nút CTA
- Link CTA
- Vị trí hiển thị
- Thứ tự sắp xếp
- Trạng thái
```

Vị trí hiển thị:

```text
home_main
home_promotion
route_page
news_page
```

## 5. Post Resource

Trường dữ liệu:

```text
- Danh mục
- Tiêu đề
- Slug
- Ảnh đại diện
- Mô tả ngắn
- Nội dung
- SEO title
- SEO description
- Trạng thái
- Ngày đăng
```

Trạng thái:

```text
draft
published
hidden
```

## 6. Route Resource

Trường dữ liệu:

```text
- Tên tuyến
- Slug
- Điểm đi
- Điểm đến
- Thời gian di chuyển dự kiến
- Khoảng cách
- Giá từ
- Ảnh đại diện
- Mô tả
- Link đặt vé riêng
- Trạng thái
```

## 7. Schedule Resource

Trường dữ liệu:

```text
- Tuyến xe
- Giờ đi
- Giờ đến dự kiến
- Loại xe
- Giá vé tham khảo
- Ghi chú
- Thứ tự hiển thị
- Trạng thái
```

## 8. Page Resource

Dùng để quản lý các trang tĩnh:

```text
- Giới thiệu
- Hướng dẫn đặt vé
- Chính sách đổi trả vé
- Chính sách bảo mật
- Điều khoản sử dụng
```

Trường dữ liệu:

```text
- Tiêu đề
- Slug
- Nội dung
- SEO title
- SEO description
- Trạng thái
```

## 9. Setting Resource

Cấu hình website:

```text
- Tên nhà xe
- Logo
- Favicon
- Hotline
- Email
- Địa chỉ
- Facebook
- Zalo
- Google Map
- Link tool đặt vé mặc định
- Script chat
- Script Google Analytics
- Script Facebook Pixel
```

## 10. Contact Resource

Admin xem danh sách liên hệ từ khách hàng.

Trường dữ liệu:

```text
- Họ tên
- Số điện thoại
- Email
- Nội dung
- Trạng thái xử lý
- Ngày gửi
```

Trạng thái:

```text
new
processing
done
```
