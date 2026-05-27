# Thiết kế Website khách hàng

## 1. Định hướng giao diện

Website nên thiết kế theo hướng hiện đại, rõ ràng, dễ đọc thông tin và tối ưu cho mobile. Mục tiêu chính là giúp khách hàng nhanh chóng nắm được thông tin tuyến xe, lịch trình, chính sách và bấm đặt vé.

## 2. Cấu trúc menu chính

```text
Trang chủ
Giới thiệu
Tuyến xe
Lịch trình
Khuyến mãi
Tin tức
Hướng dẫn đặt vé
Liên hệ
Đặt vé
```

Trên mobile nên có thanh nút nổi:

```text
Gọi hotline | Zalo | Đặt vé
```

## 3. Trang chủ

Các section đề xuất:

```text
1. Banner chính
2. Form tìm tuyến đơn giản hoặc nút Đặt vé
3. Tuyến xe nổi bật
4. Lịch trình phổ biến
5. Tin tức mới nhất
6. Khuyến mãi
7. Hướng dẫn đặt vé
8. Vì sao chọn chúng tôi
9. Thông tin liên hệ
10. Footer
```

## 4. Trang tuyến xe

URL đề xuất:

```text
/tuyen-xe
/tuyen-xe/tp-hcm-da-lat
/tuyen-xe/tp-hcm-can-tho
```

Nội dung trang chi tiết tuyến:

```text
- Tên tuyến
- Ảnh đại diện
- Điểm đi
- Điểm đến
- Thời gian di chuyển dự kiến
- Giá vé tham khảo
- Loại xe
- Giờ chạy tham khảo
- Điểm đón
- Điểm trả
- Mô tả tuyến
- Câu hỏi thường gặp
- Nút đặt vé
- Tin liên quan
```

## 5. Trang lịch trình

Hiển thị bảng lịch trình tham khảo:

```text
Tuyến | Giờ đi | Giờ đến dự kiến | Loại xe | Giá từ | Ghi chú | Đặt vé
```

Lưu ý: lịch trình trên website chỉ mang tính tham khảo. Khi khách bấm đặt vé, hệ thống sẽ chuyển sang tool bên thứ ba để xem giờ chạy và ghế thực tế.

## 6. Trang tin tức

URL đề xuất:

```text
/tin-tuc
/tin-tuc/lich-chay-xe-tet-2026
```

Danh mục tin tức:

```text
- Thông báo
- Khuyến mãi
- Kinh nghiệm đi xe
- Hướng dẫn đặt vé
- Chính sách
```

Mỗi bài viết gồm:

```text
- Tiêu đề
- Slug
- Ảnh đại diện
- Mô tả ngắn
- Nội dung
- Ngày đăng
- Tác giả
- Bài viết liên quan
- SEO title
- SEO description
```

## 7. Trang hướng dẫn đặt vé

Nội dung nên có:

```text
Bước 1: Chọn tuyến xe
Bước 2: Chọn ngày đi
Bước 3: Bấm nút Đặt vé
Bước 4: Hoàn tất thông tin trên form bên thứ ba
Bước 5: Nhận xác nhận vé từ hệ thống đặt vé
```

## 8. Trang liên hệ

Thông tin hiển thị:

```text
- Hotline
- Zalo
- Email
- Địa chỉ văn phòng
- Bản đồ Google Map
- Form liên hệ
```

Form liên hệ gồm:

```text
Họ tên
Số điện thoại
Email
Nội dung
```
