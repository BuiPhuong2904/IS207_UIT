<!DOCTYPE html>
<html lang="vi">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Hóa đơn #{{ $data['order_code'] }}</title>
    <style type="text/css">
        /* Reset cơ bản cho Email Client */
        body { width: 100% !important; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; margin: 0; padding: 0; font-family: 'Open Sans', Helvetica, Arial, sans-serif; line-height: 1.5; background-color: #f9fafb; color: #333333; }
        img { outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; display: block; }
        table { border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
        td { vertical-align: top; }
        
        /* Mobile Responsive */
        @media only screen and (max-width: 600px) {
            .container { width: 100% !important; padding: 20px !important; }
            .col-mobile { display: block !important; width: 100% !important; padding-right: 0 !important; padding-left: 0 !important; margin-bottom: 20px !important; border: none !important; }
            .text-right-mobile { text-align: left !important; }
        }
    </style>
</head>
<body style="margin: 0; padding: 0; background-color: #f9fafb;">

    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f9fafb; table-layout: fixed;">
        <tr>
            <td align="center" style="padding: 40px 0;">
                
                <table border="0" cellpadding="0" cellspacing="0" width="800" class="container" style="background-color: #ffffff; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); width: 800px; max-width: 800px; margin: 0 auto;">
                    <tr>
                        <td style="padding: 40px;">
                            
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom: 40px;">
                                <tr>
                                    <td valign="top" width="60%">
                                        <table border="0" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="padding-right: 15px;">
                                                    <img src="https://res.cloudinary.com/dna9qbejm/image/upload/v1762341326/logo_x0erjc.png" alt="Logo" width="70" height="70" style="border-radius: 4px; width: 90px; height: auto;">
                                                </td>
                                                <td valign="middle">
                                                    <h1 style="font-size: 22px; font-weight: bold; color: #0D47A1; margin: 0; font-family: Helvetica, Arial, sans-serif;">GRYND</h1>
                                                    <p style="margin: 0; color: #6b7280; font-size: 14px;">yobae@gmail.com</p>
                                                    <p style="margin: 0; color: #6b7280; font-size: 14px;">012 345 6789</p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td valign="top" width="40%" style="text-align: right;" class="text-right-mobile">
                                        <h2 style="font-size: 32px; font-weight: bold; color: #d1d5db; text-transform: uppercase; margin: 0; line-height: 1;">Hóa đơn</h2>
                                        <p style="color: #6b7280; font-weight: 600; font-size: 16px; margin: 5px 0 0 0;">#{{ $data['order_code'] }}</p>
                                    </td>
                                </tr>
                            </table>

                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-top: 2px solid #e5e7eb; border-bottom: 2px solid #e5e7eb; margin-bottom: 30px;">
                                <tr>
                                    <td valign="top" width="60%" class="col-mobile" style="padding: 20px 20px 20px 0; border-right: 2px solid #f3f4f6;">
                                        <p style="text-transform: uppercase; font-size: 11px; font-weight: bold; color: #9ca3af; letter-spacing: 1px; margin: 0 0 10px 0;">Thực hiện thanh toán</p>
                                        <p style="font-weight: bold; color: #0D47A1; margin: 0 0 5px 0; font-size: 15px;">GRYND</p>
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-size: 13px; color: #4b5563;">
                                            <tr><td width="20" style="padding-bottom: 5px;">📍</td><td style="padding-bottom: 5px;">Đường Hàn Thuyên, Khu phố 34, Phường Linh Xuân, TPHCM</td></tr>
                                            <tr><td width="20" style="padding-bottom: 5px;">🌐</td><td style="padding-bottom: 5px;">www.yobae.vn</td></tr>
                                            <tr><td width="20">📞</td><td>0123 456 789</td></tr>
                                        </table>
                                    </td>
                                    <td valign="top" width="40%" class="col-mobile" style="padding: 20px 0 20px 30px;">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                            <tr>
                                                <td style="padding-bottom: 20px;">
                                                    <p style="text-transform: uppercase; font-size: 11px; font-weight: bold; color: #9ca3af; letter-spacing: 1px; margin: 0 0 5px 0;">Ngày lập hóa đơn</p>
                                                    <p style="font-weight: bold; color: #111827; font-size: 16px; margin: 0;">{{ $data['date'] }}</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p style="text-transform: uppercase; font-size: 11px; font-weight: bold; color: #9ca3af; letter-spacing: 1px; margin: 0 0 5px 0;">Ngày thanh toán</p>
                                                    <p style="font-weight: bold; color: #111827; font-size: 16px; margin: 0;">{{ $data['date'] }}</p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom: 10px;">
                                <thead>
                                    <tr>
                                        <th align="left" style="padding: 15px 0; font-size: 12px; color: #6b7280; text-transform: uppercase; font-weight: 600; border-bottom: 2px solid #e5e7eb; width: 5%;">#</th>
                                        <th align="left" style="padding: 15px 0; font-size: 12px; color: #6b7280; text-transform: uppercase; font-weight: 600; border-bottom: 2px solid #e5e7eb; width: 55%;">Sản phẩm</th>
                                        <th align="center" style="padding: 15px 0; font-size: 12px; color: #6b7280; text-transform: uppercase; font-weight: 600; border-bottom: 2px solid #e5e7eb; width: 15%;">Số lượng</th>
                                        <th align="right" style="padding: 15px 0; font-size: 12px; color: #6b7280; text-transform: uppercase; font-weight: 600; border-bottom: 2px solid #e5e7eb; width: 25%;">Giá tiền (VND)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data['items'] as $index => $item)
                                    <tr>
                                        <td style="padding: 20px 0; border-bottom: 1px solid #f3f4f6; color: #374151;">{{ $index + 1 }}</td>
                                        <td style="padding: 20px 0; border-bottom: 1px solid #f3f4f6;">
                                            <p style="font-weight: bold; color: #111827; margin: 0; font-size: 15px;">
                                                {{ $item['product_name'] ?? $item['name'] ?? 'Sản phẩm' }}
                                            </p>
                                            @if(isset($item['weight']))
                                            <p style="font-size: 13px; color: #6b7280; margin: 4px 0 0 0;">
                                                {{ $item['weight'] }} {{ $item['unit'] ?? '' }}
                                            </p>
                                            @endif
                                        </td>
                                        <td align="center" style="padding: 20px 0; border-bottom: 1px solid #f3f4f6; color: #111827;">{{ $item['quantity'] ?? 1 }}</td>
                                        <td align="right" style="padding: 20px 0; border-bottom: 1px solid #f3f4f6; font-weight: 600; color: #111827;">
                                            {{ number_format($item['unit_price'] ?? 0, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom: 30px;">
                                <tr>
                                    <td style="border-top: 2px solid #e5e7eb; padding-top: 20px;">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                            <tr>
                                                <td align="left" style="padding-bottom: 10px; font-size: 14px; font-weight: bold; color: #374151;">Tổng tiền</td>
                                                <td align="right" style="padding-bottom: 10px; font-size: 14px; font-weight: bold; color: #374151;">
                                                    {{ number_format($data['subtotal'] ?? ($data['total_amount'] + ($data['discount_value'] ?? 0)), 0, ',', '.') }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="left" style="padding-bottom: 10px; font-size: 14px; font-weight: bold; color: #374151;">Giá giảm</td>
                                                <td align="right" style="padding-bottom: 10px; font-size: 14px; font-weight: bold; color: #374151;">
                                                    {{ number_format($data['discount_value'] ?? 0, 0, ',', '.') }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="left" style="padding-bottom: 10px; font-size: 14px; font-weight: bold; color: #374151;">Mã giảm giá</td>
                                                <td align="right" style="padding-bottom: 10px; font-size: 14px; font-weight: bold; color: #374151;">
                                                    {{ $data['promotion_code'] ?? '--' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="left" style="padding-top: 15px; font-size: 18px; font-weight: bold; color: #111827; border-top: 1px solid #e5e7eb;">
                                                    Tổng thanh toán (VND)
                                                </td>
                                                <td align="right" style="padding-top: 15px; font-size: 22px; font-weight: bold; color: #9F0712; border-top: 1px solid #e5e7eb;">
                                                    {{ number_format($data['total_amount'], 0, ',', '.') }}
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td style="background-color: #f9fafb; padding: 20px; border-radius: 6px;">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                            <tr>
                                                <td style="font-style: italic; color: #4b5563; font-size: 13px; line-height: 1.6;">
                                                    Vui lòng yêu cầu xuất hóa đơn trong vòng 7 ngày kể từ lúc mua hàng.<br>
                                                    Cám ơn bạn đã ghé thăm dịch vụ của chúng tôi.
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-top: 10px;">
                                <tr>
                                    <td style="padding-bottom: 10px;">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                            <tr>
                                                <td width="1" style="white-space: nowrap; padding-right: 20px; vertical-align: middle;">
                                                    <h4 style="font-size: 12px; font-weight: bold; color: #6b7280; text-transform: uppercase; margin: 0; letter-spacing: 1px;">Thông tin khách hàng</h4>
                                                </td>
                                                
                                                <td width="99%" style="vertical-align: middle;">
                                                    <div style="border-top: 1px solid #e5e7eb; font-size: 0; line-height: 0;">&nbsp;</div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                            <tr>
                                                <td valign="top" width="100%">
                                                    <p style="font-weight: bold; color: #1f2937; text-transform: uppercase; font-size: 14px; margin: 0;">
                                                        {{ $data['customer_name'] ?? 'Khách vãng lai' }}
                                                    </p>
                                                    <div style="font-size: 13px; color: #6b7280; line-height: 1.6;">
                                                        @if(!empty($data['address']))
                                                            <div>{{ $data['address'] }}</div>
                                                        @endif
                                                        @if(!empty($data['phone_number']))
                                                            <div>SĐT: {{ $data['phone_number'] }}</div>
                                                        @endif
                                                        @if(!empty($data['email']))
                                                            <div>Email: {{ $data['email'] }}</div>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>
                </table>
                
            </td>
        </tr>
    </table>
</body>
</html>