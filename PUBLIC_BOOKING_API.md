# Public Booking API

Tài liệu tích hợp hệ thống website công khai `web.nhaxenhatduong.com` với backend Nhật Dương và hệ thống quản lý vé VeXeRe.

## 1. Mục Tiêu

Website công khai không gọi trực tiếp VeXeRe. Website gọi backend Nhật Dương qua một API nội bộ. Backend chịu trách nhiệm:

1. Xác thực hệ thống website bằng API key nội bộ.
2. Giữ ghế trên VeXeRe.
3. Cập nhật thông tin hành khách.
4. Tính giá từ dữ liệu VeXeRe, không tin giá do frontend gửi.
5. Chờ website xác nhận khách đã thanh toán.
6. Tự thanh toán vé trên VeXeRe.
7. Lưu trạng thái đơn và chống tạo đơn trùng.

## 2. Kiến Trúc

```text
Khách hàng
    |
    v
web.nhaxenhatduong.com
    |
    | Server-to-server HTTPS
    | X-Internal-Booking-Key
    | Idempotency-Key
    v
NhatDuong API
    |
    +--> PostgreSQL
    |
    +--> VeXeRe BMS API
```

Website hiện là hệ thống server-rendered. API key phải được lưu ở backend của website, không được đưa vào JavaScript chạy trên trình duyệt.

## 3. Base URL

Thay `${API_BASE_URL}` bằng URL public của backend Nhật Dương.

```text
${API_BASE_URL}/api/public-booking
```

Ví dụ:

```text
https://api.nhaxenhatduong.com/api/public-booking
```

## 4. Xác Thực Nội Bộ

Mỗi request phải gửi header:

```http
X-Internal-Booking-Key: <shared-secret>
```

Request tạo đơn phải có thêm:

```http
Idempotency-Key: <unique-request-key>
```

### 4.1. Cấu hình backend Nhật Dương

Không commit API key vào source code hoặc `appsettings.json`. Cấu hình bằng secret manager hoặc biến môi trường:

```text
PublicBooking__ApiKey=<shared-secret>
VeXeRe__OnlineBookingPaymentInfo=1:Tại văn phòng
```

Tạo secret ngẫu nhiên trên PowerShell:

```powershell
$bytes = [byte[]]::new(32)
[Security.Cryptography.RandomNumberGenerator]::Fill($bytes)
[Convert]::ToBase64String($bytes)
```

### 4.2. Quy tắc bảo mật

- Chỉ gọi API qua HTTPS.
- Không gửi API key từ browser.
- Không ghi API key, access token VeXeRe hoặc dữ liệu thẻ vào log.
- Mỗi môi trường nên dùng một API key khác nhau.
- Khi nghi ngờ lộ key, phải thu hồi và cấp key mới.
- Không đưa file HAR chứa PII hoặc credential vào repository.

## 5. Luồng Nghiệp Vụ

### Bước 1: Website tạo đơn

Website backend gọi:

```http
POST /api/public-booking/orders
```

Backend Nhật Dương:

1. Kiểm tra API key.
2. Kiểm tra `Idempotency-Key`.
3. Ghi đơn ở trạng thái `PROCESSING`.
4. Gọi `POST /api/v1/booking/offline` của VeXeRe để giữ ghế.
5. Lấy giá gốc và giảm giá từ response VeXeRe.
6. Gọi `PUT /api/v1/booking` để cập nhật hành khách.
7. Lưu đơn ở trạng thái `PENDING_PAYMENT`.
8. Trả về mã đơn và số tiền cần thanh toán.

### Bước 2: Khách thanh toán trên website

Website chuyển khách sang cổng thanh toán mà dự án lựa chọn, ví dụ PayOS, MoMo, VNPay hoặc chuyển khoản ngân hàng.

API này không tự xác minh giao dịch của nhà cung cấp thanh toán. Website phải xác minh webhook/callback của nhà cung cấp trước khi gọi bước tiếp theo.

### Bước 3: Website xác nhận thanh toán

Sau khi xác nhận giao dịch thành công, website backend gọi:

```http
POST /api/public-booking/orders/{orderId}/pay
```

Backend Nhật Dương:

1. Kiểm tra đơn còn ở trạng thái thanh toán được.
2. Gọi API VeXeRe để chuyển vé sang trạng thái đã thanh toán.
3. Cập nhật ticket nội bộ thành `PAID`.
4. Ghi giao dịch vào `vexere_transactions`.
5. Cập nhật đơn thành `PAID`.

## 6. API Tạo Đơn

### Request

```http
POST ${API_BASE_URL}/api/public-booking/orders HTTP/1.1
Content-Type: application/json
X-Internal-Booking-Key: <shared-secret>
Idempotency-Key: web-order-20260930-000001
```

```json
{
  "tripId": 32156454,
  "fromId": 164780,
  "toId": 165076,
  "seatCode": "1C|1|1|3",
  "seatType": 2,
  "customerName": "Nguyen Van A",
  "customerPhone": "0900000000",
  "customerEmail": "customer@example.com",
  "departureDate": "2026-09-30",
  "departureTime": "23:30",
  "pickupName": "VPSG",
  "pickupInfo": "VPSG||0||",
  "dropOffInfo": "Vp Thich Quang Duc Nha Trang",
  "dropOffTime": "2026-10-01T06:21:00+07:00",
  "dropOffPointId": 165076
}
```

### Request fields

| Field | Type | Required | Description |
|---|---|---:|---|
| `tripId` | integer | Yes | ID chuyến VeXeRe, không phải city ID. |
| `fromId` | integer | Yes | ID điểm đón/đi trên VeXeRe. |
| `toId` | integer | Yes | ID điểm trả/đến trên VeXeRe. |
| `seatCode` | string | Yes | Mã ghế đầy đủ từ seat map, ví dụ `1C|1|1|3`. Không chỉ gửi `1C`. |
| `seatType` | integer | Yes | Loại ghế VeXeRe, mặc định `2`. |
| `customerName` | string | Yes | Tối đa 200 ký tự. |
| `customerPhone` | string | Yes | Tối đa 50 ký tự. |
| `customerEmail` | string | No | Email hành khách. |
| `departureDate` | date | Yes | Định dạng `YYYY-MM-DD`. Không được là ngày quá khứ. |
| `departureTime` | string | Yes | Định dạng `HH:mm`. |
| `pickupName` | string | No | Tên/mã điểm đón. |
| `pickupInfo` | string | No | Chuỗi thông tin điểm đón của VeXeRe. |
| `dropOffInfo` | string | No | Thông tin điểm trả. |
| `dropOffTime` | datetime | No | Thời gian trả khách. |
| `dropOffPointId` | integer | No | ID điểm trả nếu có. |


### Response thành công

HTTP `201 Created`:

```json
{
  "orderId": 1001,
  "status": "PENDING_PAYMENT",
  "amount": 689000,
  "currency": "VND",
  "bookingCode": "ABC1234",
  "ticketCode": "XYZ5678",
  "paymentRequired": true
}
```

`amount` là:

```text
amount = fare - discount
```

Website phải hiển thị đúng `amount` do backend trả về, không dùng giá tự tính từ frontend.

### Idempotency

Nếu website retry cùng request vì timeout, phải gửi lại cùng `Idempotency-Key` và cùng body.

- Cùng key, cùng body: backend trả lại đơn hiện có.
- Cùng key, body khác: HTTP `409 Conflict`.
- Không có key: HTTP `400 Bad Request`.

## 7. API Xác Nhận Thanh Toán Và Tự Pay VeXeRe

### Request

```http
POST ${API_BASE_URL}/api/public-booking/orders/1001/pay HTTP/1.1
Content-Type: application/json
X-Internal-Booking-Key: <shared-secret>
```

```json
{
  "paymentReference": "PAYOS-20260930-000001"
}
```

`paymentReference` là mã giao dịch từ cổng thanh toán hoặc ngân hàng. API hiện tại không nhận `amount` từ client để tránh giả mạo số tiền.

### Response thành công

HTTP `200 OK`:

```json
{
  "orderId": 1001,
  "status": "PAID",
  "amount": 689000,
  "currency": "VND",
  "bookingCode": "ABC1234",
  "ticketCode": "XYZ5678",
  "paymentRequired": false
}
```

### Retry thanh toán

Có thể gọi lại endpoint pay khi request trước bị timeout hoặc trạng thái là `PAYMENT_FAILED`. Backend dùng mã giao dịch nội bộ `PB-{orderId}` để tránh ghi giao dịch nội bộ trùng.

Website không được gọi endpoint pay trước khi xác minh khách đã thanh toán thành công. Endpoint pay dùng `orderId` và `paymentReference` để retry, không yêu cầu `Idempotency-Key` riêng.

## 8. API Kiểm Tra Đơn

### Request

```http
GET ${API_BASE_URL}/api/public-booking/orders/1001 HTTP/1.1
X-Internal-Booking-Key: <shared-secret>
```

### Response

```json
{
  "orderId": 1001,
  "status": "PENDING_PAYMENT",
  "amount": 689000,
  "currency": "VND",
  "bookingCode": null,
  "ticketCode": null,
  "paymentRequired": true,
  "error": null
}
```

Response tạo đơn có thể trả về `bookingCode` và `ticketCode` do VeXeRe cấp. Response kiểm tra đơn (`GET`) sẽ ẩn hai mã này khi đơn chưa `PAID`; sau khi `PAID`, các mã được trả về đầy đủ.

## 9. Trạng Thái Đơn

| Status | Ý nghĩa | Có thể gọi pay? |
|---|---|---:|
| `PROCESSING` | Backend đang tạo giữ chỗ/cập nhật vé. | No |
| `PENDING_PAYMENT` | Đã giữ ghế, chờ website xác nhận thanh toán. | Yes |
| `PAYING` | Backend đang gọi thanh toán VeXeRe. | No |
| `PAID` | Vé VeXeRe và dữ liệu nội bộ đã thanh toán. | No |
| `BOOKING_FAILED` | Không tạo được giữ chỗ hoặc cập nhật hành khách. | No |
| `PAYMENT_FAILED` | Đã có vé nhưng thanh toán VeXeRe thất bại. | Yes, retry |

## 10. Ví Dụ Tích Hợp Server-to-Server

### Tạo đơn bằng cURL

```bash
curl -X POST "${API_BASE_URL}/api/public-booking/orders" \
  -H "Content-Type: application/json" \
  -H "X-Internal-Booking-Key: ${PUBLIC_BOOKING_API_KEY}" \
  -H "Idempotency-Key: web-order-20260930-000001" \
  -d '{
    "tripId": 32156454,
    "fromId": 164780,
    "toId": 165076,
    "seatCode": "1C|1|1|3",
    "seatType": 2,
    "customerName": "Nguyen Van A",
    "customerPhone": "0900000000",
    "customerEmail": "customer@example.com",
    "departureDate": "2026-09-30",
    "departureTime": "23:30",
    "pickupName": "VPSG",
    "pickupInfo": "VPSG||0||",
    "dropOffInfo": "Vp Thich Quang Duc Nha Trang"
  }'
```

### Gọi pay sau webhook thanh toán

```bash
curl -X POST "${API_BASE_URL}/api/public-booking/orders/1001/pay" \
  -H "Content-Type: application/json" \
  -H "X-Internal-Booking-Key: ${PUBLIC_BOOKING_API_KEY}" \
  -d '{
    "paymentReference": "PAYOS-20260930-000001"
  }'
```

## 11. HTTP Status Codes

| HTTP | Ý nghĩa |
|---:|---|
| `200` | Request thành công hoặc trả lại kết quả idempotent. |
| `201` | Tạo đơn mới thành công. |
| `400` | Request thiếu field hoặc sai định dạng. |
| `401` | API key không hợp lệ. |
| `404` | Không tìm thấy đơn. |
| `409` | Trùng idempotency key khác body, ghế không thể giữ hoặc trạng thái không hợp lệ. |
| `502` | Backend không nhận được kết quả hợp lệ từ VeXeRe. |
| `503` | Backend chưa cấu hình `PublicBooking__ApiKey`. |

## 12. Database Và Migration

Backend sử dụng bảng `nhatduong.public_booking_orders` để lưu đơn và chống duplicate.

Các migration cần có:

```text
20260728064829_AddPublicBookingOrders
20260728065131_AddPublicBookingOrderAreas
```

Chạy migration trong môi trường đã cấu hình đúng connection string:

```bash
dotnet ef database update --context ApplicationDbContext
```

Không chạy lệnh này trực tiếp trên production nếu chưa kiểm tra backup và kế hoạch rollback.

## 13. Files Backend Nhật Dương

```text
sms-api-server/Models/PublicBookingModels.cs
sms-api-server/Services/PublicBookingService.cs
sms-api-server/Routes/PublicBookingRoutes.cs
sms-api-server/Data/ApplicationDbContext.cs
sms-api-server/Migrations/20260728064829_AddPublicBookingOrders.cs
sms-api-server/Migrations/20260728065131_AddPublicBookingOrderAreas.cs
sms-api-server/Program.cs
```

Đăng ký route và service:

```csharp
builder.Services.AddScoped<PublicBookingService>();
app.MapPublicBookingRoutes();
```

## 14. Kiểm Tra Trước Production

- Cấu hình `PublicBooking__ApiKey` bằng secret manager.
- Cấu hình tài khoản VeXeRe ở backend, không gửi credential ra website.
- Chạy migration trên database staging trước.
- Kiểm thử tìm chuyến, seat map, giữ ghế và cập nhật khách.
- Kiểm thử callback thanh toán giả lập trên staging.
- Kiểm thử retry cùng `Idempotency-Key`.
- Kiểm thử retry thanh toán với cùng `orderId`.
- Kiểm thử request sai key và request thiếu key.
- Kiểm thử ghế đã có người đặt.
- Kiểm tra log không chứa số điện thoại, email, token hoặc API key.
- Kiểm tra callback cổng thanh toán có chữ ký hợp lệ trước khi gọi endpoint pay.

## 15. Giới Hạn Hiện Tại

1. API này chưa tích hợp trực tiếp một nhà cung cấp thanh toán cụ thể. Website phải tự xử lý checkout và webhook.
2. API chưa có endpoint tự hủy reservation khi khách không thanh toán. Cần thêm job timeout/cancel trước khi dùng production.
3. Request VeXeRe trong bridge hiện sử dụng access token và các header BMS hiện có. Một số endpoint VeXeRe có thể yêu cầu `X-Signature` động; cần kiểm thử với tài khoản thật và bổ sung cơ chế chính thức nếu VeXeRe từ chối request server-to-server.
4. Chưa có cơ chế refund tự động khi thanh toán VeXeRe thành công nhưng bước lưu nội bộ bị lỗi. Cần thêm reconciliation và recovery job.
5. Không được xem HTTP `2xx` của nhà cung cấp thanh toán là đủ; phải xác minh chữ ký webhook, mã giao dịch và số tiền trước khi gọi `/pay`.

## 16. Cảnh Báo Credential

Các file cấu hình/HAR cũ trong workspace có thể chứa credential production, access token, dữ liệu cá nhân và thông tin nhà cung cấp. Trước khi chia sẻ source hoặc đưa sang dự án khác:

- Xóa credential khỏi tài liệu và source code.
- Thu hồi/đổi các credential đã từng xuất hiện trong file cấu hình hoặc HAR.
- Kiểm tra Git history nếu các file đã từng được commit.
- Chỉ đưa placeholder như `<shared-secret>` và `${API_BASE_URL}` vào tài liệu tích hợp.
