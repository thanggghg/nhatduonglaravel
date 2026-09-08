<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Xác nhận đặt vé Nhật Dương</title>
</head>
<body style="margin:0;background:#f3f7f4;color:#173014;font-family:Arial,sans-serif">
    @php
        $paymentMethod = $booking->payment_provider === 'cash' ? 'Tiền mặt khi lên xe' : 'Chuyển khoản ngân hàng';
        $departure = optional($booking->departure_at);
    @endphp
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#f3f7f4;padding:28px 12px">
        <tr><td align="center">
            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:620px;background:#fff;border-radius:14px;overflow:hidden">
                <tr><td style="padding:12px 24px;background:#0b7f42;color:#fff;text-align:center;font-size:13px">Hotline: 1900 2879</td></tr>
                <tr><td style="padding:22px 26px;border-bottom:4px solid #fbb116;color:#062d1c;font-size:24px;font-weight:700">Nhật Dương</td></tr>
                <tr><td style="padding:30px 26px">
                    <h1 style="margin:0 0 12px;color:#0b7f42;font-size:25px">Cảm ơn bạn đã đặt vé</h1>
                    <p style="margin:0 0 22px;color:#526b5c;line-height:1.6">Thông tin đặt vé đã được ghi nhận. Nhân viên Nhật Dương sẽ liên hệ để xác nhận và hỗ trợ các bước tiếp theo.</p>
                    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse;font-size:14px">
                        @foreach([
                            'Mã đặt vé' => $booking->reference,
                            'Ghế/phòng' => implode(', ', $booking->selected_seats ?? []),
                            'Mã chuyến' => $booking->trip_code,
                            'Ngày giờ' => $departure->format('d/m/Y H:i'),
                            'Điểm đi' => $booking->route?->from_location,
                            'Điểm đến' => $booking->route?->to_location,
                            'Khách hàng' => $booking->passenger_name,
                            'Điện thoại' => $booking->passenger_phone,
                            'Email' => $booking->passenger_email,
                            'Điểm đón' => $booking->pickup_point,
                            'Điểm trả' => $booking->dropoff_point,
                            'Hình thức thanh toán' => $paymentMethod,
                            'Tổng tiền' => number_format($booking->total_amount).' VND',
                            'Ghi chú' => $booking->notes,
                        ] as $label => $value)
                            <tr>
                                <th align="left" style="width:38%;padding:10px;background:#f7faf8;border-bottom:1px solid #e2ebe5">{{ $label }}</th>
                                <td style="padding:10px;border-bottom:1px solid #e2ebe5">{{ $value ?: '-' }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <th align="left" style="padding:10px;background:#f7faf8">Nguồn</th>
                            <td style="padding:10px;word-break:break-all"><a href="{{ $sourceUrl }}" style="color:#0b7f42">{{ $sourceUrl }}</a></td>
                        </tr>
                    </table>
                    <p style="margin:24px 0 0;text-align:center"><a href="{{ route('home') }}" style="display:inline-block;padding:12px 24px;border-radius:7px;background:#0b7f42;color:#fff;text-decoration:none;font-weight:700">Về trang chủ</a></p>
                </td></tr>
                <tr><td style="padding:20px 26px;background:#f7faf8;color:#687b70;text-align:center;font-size:12px;line-height:1.6">Công ty Vận tải Nhật Dương<br>45-26 Thích Quảng Đức, KĐT Hà Quang 2, Phường Nam Nha Trang, Khánh Hòa</td></tr>
            </table>
        </td></tr>
    </table>
</body>
</html>
