<!DOCTYPE html>
<html lang="vi">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Hóa đơn #{{ $data['order_code'] }}</title>
    <style>
        /* --- CẤU HÌNH FONT CHỮ & CƠ BẢN --- */
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 13px;
            color: #333;
            line-height: 1.4;
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
        }

        td, th {
            vertical-align: top;
        }

        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .text-left { text-align: left; }
        .font-bold { font-weight: bold; }
        .uppercase { text-transform: uppercase; }
        .text-sm { font-size: 11px; }
        .text-gray { color: #6c757d; }
        
        /* --- HEADER --- */
        .header-section {
            margin-bottom: 40px;
            padding-bottom: 20px;
        }
        .brand-name {
            font-size: 20px;
            font-weight: bold;
            color: #1a202c;
            margin: 0;
        }
        .contact-info {
            font-size: 11px;
            color: #718096;
            margin-top: 5px;
        }
        .invoice-title-large {
            font-size: 40px;
            font-weight: bold;
            color: #e2e8f0; /* Màu xám nhạt như ảnh */
            text-transform: uppercase;
            line-height: 1;
            margin: 0;
        }
        .invoice-hash {
            color: #718096;
            font-size: 12px;
            margin-top: 5px;
        }

        /* --- INFO SECTIONS (Người bán, Ngày tháng) --- */
        .section-title {
            font-size: 9px;
            font-weight: bold;
            color: #a0aec0;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }
        .info-box {
            margin-bottom: 20px;
        }
        .info-value-bold {
            font-size: 13px;
            font-weight: bold;
            color: #2d3748;
            margin: 0;
        }
        .info-address {
            font-size: 11px;
            color: #4a5568;
            margin-top: 3px;
        }

        /* --- PRODUCT TABLE --- */
        .table-products {
            margin-top: 20px;
            width: 100%;
        }
        .table-products th {
            text-align: left;
            padding: 10px 0;
            border-bottom: 1px solid #e2e8f0;
            font-size: 10px;
            text-transform: uppercase;
            color: #718096;
            font-weight: bold;
        }
        .table-products td {
            padding: 15px 0;
            border-bottom: 1px solid #edf2f7;
            vertical-align: middle;
        }
        .product-name {
            font-weight: bold;
            color: #2d3748;
            font-size: 13px;
            display: block;
        }
        .product-variant {
            font-size: 11px;
            color: #a0aec0;
            margin-top: 2px;
            display: block;
        }

        /* --- SUMMARY & TOTALS --- */
        .summary-table td {
            padding: 5px 0;
            text-align: right;
        }
        .summary-label {
            font-weight: bold;
            color: #4a5568;
            font-size: 12px;
            padding-right: 20px;
        }
        .summary-value {
            font-weight: bold;
            color: #2d3748;
        }
        .total-row td {
            padding-top: 15px;
        }
        .total-label {
            font-size: 14px;
            font-weight: bold;
            color: #1a202c;
        }
        .total-value-red {
            font-size: 18px;
            font-weight: bold;
            color: #c53030; /* Màu đỏ đậm */
        }

        /* --- NOTE BOX --- */
        .note-box {
            background-color: #f8f9fa;
            border-radius: 6px;
            padding: 15px 20px;
            margin-top: 30px;
            margin-bottom: 30px;
        }
        .note-text {
            color: #718096;
            font-size: 11px;
            font-style: italic;
            margin: 0;
        }

        /* --- FOOTER BANK INFO --- */
        .footer-section {
            border-top: 1px solid #edf2f7;
            padding-top: 20px;
        }
        .footer-heading {
            font-size: 10px;
            font-weight: bold;
            color: #a0aec0;
            text-transform: uppercase;
            margin-bottom: 10px;
        }
        .bank-label {
            font-size: 9px;
            color: #a0aec0;
            text-transform: uppercase;
            margin-bottom: 2px;
        }
        .bank-value {
            font-size: 12px;
            font-weight: bold;
            color: #2d3748;
        }
    </style>
</head>
<body>

    {{-- 1. HEADER --}}
    <table class="header-section">
        <tr>
            <td width="60%">
                {{-- Logo Placeholder --}}
                <div style="display: flex; align-items: center;">
                    {{-- Thay src bằng logo thật của bạn --}}
                    {{-- <img src="{{ public_path('path/to/logo.png') }}" style="height: 40px; margin-right: 15px;"> --}}
                    
                    {{-- Tạm dùng text logo nếu chưa có ảnh --}}
                    <div>
                        <h1 class="brand-name">Grynd</h1>
                        <div class="contact-info">
                            yobae@gmail.com<br>
                            012 345 6789
                        </div>
                    </div>
                </div>
            </td>
            <td width="40%" class="text-right">
                <div class="invoice-title-large">HÓA ĐƠN</div>
                <div class="invoice-hash">#{{ $data['order_code'] }}</div>
            </td>
        </tr>
    </table>

    {{-- 2. INFO GRID --}}
    <table style="margin-bottom: 10px;">
        <tr>
            {{-- Cột Trái: Thông tin bên bán --}}
            <td width="55%" style="padding-right: 20px;">
                <div class="info-box">
                    <div class="section-title">Thực hiện thanh toán</div>
                    <p class="info-value-bold">Grynd</p>
                    <div class="info-address">
                        📍 Đường Hàn Thuyên, Khu phố 34, Phường Linh Xuân, TPHCM<br>
                        🌐 www.yobae.vn<br>
                        📞 0123 456 789
                    </div>
                </div>
                
                {{-- Tận dụng không gian để hiển thị khách hàng (vì layout ảnh mẫu không rõ phần này ở đâu, ta để dưới đây cho hợp lý) --}}
                <div class="info-box" style="margin-top: 15px;">
                    <div class="section-title">Khách hàng</div>
                    <p class="info-value-bold">{{ $data['customer_name'] }}</p>
                    <div class="info-address">
                        {{ $data['address'] }} <br>
                        {{ $data['phone_number'] }}
                    </div>
                </div>
            </td>

            {{-- Cột Phải: Ngày tháng --}}
            <td width="45%">
                <table width="100%">
                    <tr>
                        <td style="padding-bottom: 15px;">
                            <div class="section-title">Ngày lập hóa đơn</div>
                            <div class="info-value-bold">{{ $data['date'] }}</div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="section-title">Ngày thanh toán</div>
                            {{-- Giả sử ngày thanh toán là ngày lập, hoặc lấy biến khác nếu có --}}
                            <div class="info-value-bold">{{ $data['date'] }}</div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    {{-- 3. PRODUCT TABLE --}}
    <table class="table-products">
        <thead>
            <tr>
                <th width="5%">#</th>
                <th width="55%">Sản phẩm</th>
                <th width="15%" class="text-center">Số lượng</th>
                <th width="25%" class="text-right">Giá tiền (VND)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data['items'] as $index => $item)
            <tr>
                <td class="text-gray">{{ $index + 1 }}</td>
                <td>
                    <span class="product-name">{{ $item['product_name'] ?? $item['name'] }}</span>
                    {{-- Hiển thị Variant/Size nếu có --}}
                    @if(isset($item['variant']) || isset($item['unit']))
                        <span class="product-variant">{{ $item['variant'] ?? '2kg' }} {{-- Placeholder giống ảnh --}}</span>
                    @else
                        <span class="product-variant">Tiêu chuẩn</span>
                    @endif
                </td>
                <td class="text-center">{{ $item['quantity'] }}</td>
                <td class="text-right font-bold">{{ number_format($item['final_price'] ?? $item['unit_price'] ?? 0) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- 4. SUMMARY & TOTALS --}}
    <table style="margin-top: 10px;">
        <tr>
            <td width="50%"></td>
            <td width="50%">
                <table class="summary-table" width="100%">
                    <tr>
                        <td class="summary-label">Tổng tiền</td>
                        <td class="summary-value">{{ number_format($data['total_amount']) }}</td>
                    </tr>
                    <tr>
                        <td class="summary-label">Giá giảm</td>
                        <td class="summary-value">0</td>
                    </tr>
                    <tr>
                        <td class="summary-label">Mã giảm giá</td>
                        <td class="summary-value text-gray">-</td>
                    </tr>
                    <tr class="total-row">
                        <td class="total-label">Tổng thanh toán (VND)</td>
                        <td class="total-value-red">{{ number_format($data['total_amount']) }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    {{-- 5. NOTE BOX --}}
    <div class="note-box">
        <table width="100%">
            <tr>
                <td width="30" style="vertical-align: middle;">
                    {{-- Icon chat đơn giản bằng ký tự hoặc để trống --}}
                    <span style="font-size: 20px; color: #a0aec0;">💬</span>
                </td>
                <td style="vertical-align: middle;">
                    <p class="note-text">
                        Vui lòng xuất hóa đơn trong vòng 7 ngày kể từ lúc mua hàng.<br>
                        Cám ơn bạn đã ghé thăm dịch vụ của chúng tôi.
                    </p>
                </td>
            </tr>
        </table>
    </div>

    {{-- 6. FOOTER (BANK INFO) --}}
    <div class="footer-section">
        <div class="footer-heading">Thông tin thanh toán</div>
        <table width="100%">
            <tr>
                <td width="33%">
                    <div class="bank-label">Tên Ngân Hàng</div>
                    <div class="bank-value">ABCD BANK</div>
                </td>
                <td width="33%">
                    <div class="bank-label">Mã code (Tên TK)</div>
                    <div class="bank-value">ABCDUSBXXX (SƠN TÙNG MTP)</div>
                </td>
                <td width="33%" class="text-right">
                    <div class="bank-label">Mã tài khoản</div>
                    <div class="bank-value">37474892300011</div>
                </td>
            </tr>
        </table>
    </div>

</body>
</html>