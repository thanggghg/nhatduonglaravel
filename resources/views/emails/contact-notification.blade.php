<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Yêu cầu liên hệ mới - Nhật Dương</title>
</head>
<body style="margin:0;background:#f5f7f2;color:#17362b;font-family:Arial,sans-serif">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#f5f7f2;padding:28px 12px">
        <tr><td align="center">
            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:620px;overflow:hidden;background:#fff;border:1px solid #e5dfcc;border-radius:14px">
                <tr><td style="padding:12px 24px;background:#073a2a;color:#fff;text-align:center;font-size:13px">Hotline Nhật Dương: 1900 2879</td></tr>
                <tr><td style="padding:22px 26px;background:#fffceb;border-bottom:4px solid #f9df12;color:#073a2a;font-size:23px;font-weight:700">Yêu cầu liên hệ mới</td></tr>
                <tr><td style="padding:30px 26px">
                    <p style="margin:0 0 22px;color:#526b5c;font-size:14px;line-height:1.6">Khách hàng vừa gửi yêu cầu hỗ trợ từ website Nhà xe Nhật Dương.</p>
                    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse;font-size:14px">
                        @foreach([
                            'Mã yêu cầu' => '#'.$contact->id,
                            'Thời gian gửi' => $contact->created_at?->format('d/m/Y H:i'),
                            'Họ và tên' => $contact->name,
                            'Số điện thoại' => $contact->phone,
                            'Email' => $contact->email ?: 'Không cung cấp',
                        ] as $label => $value)
                            <tr>
                                <th align="left" style="width:36%;padding:11px;background:#f8faf7;border-bottom:1px solid #e5ebe6;color:#53675d">{{ $label }}</th>
                                <td style="padding:11px;border-bottom:1px solid #e5ebe6;color:#17362b;font-weight:600">{{ $value ?: '-' }}</td>
                            </tr>
                        @endforeach
                    </table>
                    <div style="margin-top:22px;padding:17px;background:#fffbea;border:1px solid #eadf9a;border-radius:10px">
                        <strong style="display:block;margin-bottom:8px;color:#6b5c00;font-size:12px;text-transform:uppercase">Nội dung cần hỗ trợ</strong>
                        <p style="margin:0;color:#344b3f;font-size:14px;line-height:1.65;white-space:pre-wrap">{{ $message }}</p>
                    </div>
                    <p style="margin:22px 0 0;color:#728078;font-size:12px;line-height:1.5;word-break:break-all">Nguồn: <a href="{{ $sourceUrl }}" style="color:#0b7040">{{ $sourceUrl }}</a></p>
                </td></tr>
                <tr><td style="padding:19px 26px;background:#073a2a;color:rgba(255,255,255,.72);text-align:center;font-size:12px;line-height:1.6">Nhà xe Nhật Dương<br>Email này được gửi tự động từ biểu mẫu liên hệ trên website.</td></tr>
            </table>
        </td></tr>
    </table>
</body>
</html>
