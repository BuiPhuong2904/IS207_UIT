@extends('user.layouts.user_layout')

@section('title', 'GRYND - Hóa đơn')

@section('content')

@php
    // 1. Dữ liệu Đơn hàng
    $order = (object) [
        'code' => 'AB2324-01',
        'created_at' => \Carbon\Carbon::parse('2025-11-30'),
        'paid_at' => \Carbon\Carbon::parse('2025-11-30'),
        
        'customer' => (object) [
            'name' => 'Nguyễn Văn A',
            'phone' => '0909 123 456',
            'address' => 'Số 10, Đường Nguyễn Huệ, Quận 1, TP.HCM',
            'email' => 'khachhang@example.com'
        ],

        'items' => [
            (object) [
                'name' => 'Tạ tập gym',
                'variant' => '2kg',
                'quantity' => 1,
                'price' => 149000
            ],
            (object) [
                'name' => 'Đồ tập thể thao đơn giản phù hợp với bộ môn Yoga, Cardio',
                'variant' => 'XL',
                'quantity' => 1,
                'price' => 156000
            ]
        ],

        'subtotal' => 305000,
        'discount_amount' => 0,
        'discount_code' => null,
        'total' => 305000
    ];

    // 2. Dữ liệu Ngân hàng (Thêm mới phần này để làm động Footer)
    $bank_info = (object) [
        'account_owner' => 'Sơn Tùng MTP',
        'address' => '123 Bình Nguyên Vô Tận',
        'phone' => '012 345 6789',
        'bank_name' => 'ABCD BANK',
        'bank_code' => 'ABCDUSBXXX', // Mã Code / Swift Code
        'account_number' => '37474892300011'
    ];
@endphp

<div class="bg-gray-50 min-h-screen py-10 font-open-sans">
    <div class="max-w-4xl mx-auto bg-white shadow-lg p-10 rounded-sm">
        
        {{-- Header: Logo & Invoice ID --}}
        <div class="flex justify-between items-start mb-10">
            <div class="flex items-center gap-4">
                <div class="-ml-2">
                    <img src="images/profile/logo.png" 
                        alt="Logo" 
                        class="h-18 w-18">
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 font-montserrat">Grynd</h1>
                    <p class="text-gray-500 text-sm">yobae@gmail.com</p>
                    <p class="text-gray-500 text-sm">012 345 6789</p>
                </div>
            </div>
            <div class="text-right">
                <h2 class="text-4xl font-bold text-gray-300 uppercase">Hóa đơn</h2>
                <p class="text-gray-500 font-medium mt-1">#AB2324-01</p>
            </div>
        </div>

        {{-- Info Section: Payment To & Dates --}}
        <div class="grid grid-cols-1 md:grid-cols-5 border-t-2 border-b-2 border-gray-200 mb-8">
            
            {{-- Left: Payment Info --}}
            <div class="md:col-span-3 py-5 md:border-r-2 border-gray-200 md:pr-10">
                <h3 class="uppercase text-xs font-bold text-gray-400 tracking-wider mb-4">Thực hiện thanh toán</h3>
                <p class="font-bold text-gray-900 mb-2">Grynd</p>
                
                <div class="space-y-2 text-sm text-gray-600">
                    <div class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-gray-800 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" /></svg>
                        <span>Đường Hàn Thuyên, Khu phố 34, Phường Linh Xuân, TPHCM</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-gray-800 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M21.721 12.752a9.711 9.711 0 0 0-.945-5.003 12.754 12.754 0 0 1-4.339 2.708 18.991 18.991 0 0 1-.214 4.772 17.165 17.165 0 0 0 5.498-2.477ZM14.634 15.55a17.324 17.324 0 0 0 .332-4.647c-.952.227-1.945.347-2.966.347-1.021 0-2.014-.12-2.966-.347a17.515 17.515 0 0 0 .332 4.647 17.385 17.385 0 0 0 5.268 0ZM9.772 17.119a18.963 18.963 0 0 0 4.456 0A17.182 17.182 0 0 1 12 21.724a17.18 17.18 0 0 1-2.228-4.605ZM7.777 15.23a18.87 18.87 0 0 1-.214-4.774 12.753 12.753 0 0 1-4.34-2.708 9.711 9.711 0 0 0-.944 5.004 17.165 17.165 0 0 0 5.498 2.477ZM21.356 14.752a9.765 9.765 0 0 1-7.478 6.817 18.64 18.64 0 0 0 1.988-4.718 18.627 18.627 0 0 0 5.49-2.098ZM2.644 14.752c1.682.971 3.53 1.688 5.49 2.099a18.64 18.64 0 0 0 1.988 4.718 9.765 9.765 0 0 1-7.478-6.816ZM13.878 2.43a9.755 9.755 0 0 1 6.116 3.986 11.267 11.267 0 0 1-3.746 2.504 18.63 18.63 0 0 0-2.37-6.49ZM12 2.276a17.152 17.152 0 0 1 2.805 7.121c-.897.23-1.837.353-2.805.353-.968 0-1.908-.122-2.805-.353A17.151 17.151 0 0 1 12 2.276ZM10.122 2.43a18.629 18.629 0 0 0-2.37 6.49 11.266 11.266 0 0 1-3.746-2.504 9.754 9.754 0 0 1 6.116-3.985Z" />
                        </svg>
                        <span>www.yobae.vn</span>
                    </div>
                    <div class="flex items-center gap-2">
                         <svg class="w-4 h-4 text-gray-800 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" /></svg>
                        <span>0123 456 789</span>
                    </div>
                </div>
            </div>

            {{-- Right: Date Info --}}
            <div class="md:col-span-2 py-5 md:pl-10 mt-6 md:mt-0 flex flex-col justify-between">
                <div>
                    <h3 class="uppercase text-xs font-bold text-gray-400 tracking-wider mb-2">Ngày lập hóa đơn</h3>
                    <p class="font-bold text-gray-900 text-lg">{{ $order->created_at->format('d/m/Y') }}</p>
                </div>
                <div>
                    <h3 class="uppercase text-xs font-bold text-gray-400 tracking-wider mb-2">Ngày thanh toán</h3>
                    <p class="font-bold text-gray-900 text-lg">{{ $order->paid_at->format('d/m/Y') }}</p>
                </div>
            </div>
        </div>

        {{-- Table Items --}}
        <table class="w-full mb-0">
            <thead>
                <tr class="border-b-2 border-gray-200">
                    <th class="text-left py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider w-10">#</th>
                    <th class="text-left py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Sản phẩm</th>
                    <th class="text-center py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider w-24">Số lượng</th>
                    <th class="text-right py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider w-40">Giá tiền (VND)</th>
                </tr>
            </thead>
            <tbody class="text-gray-800">
                @foreach($order->items as $index => $item)
                <tr class="border-b border-gray-200 last:border-0">
                    <td class="py-5 align-top">{{ $index + 1 }}</td>
                    <td class="py-5">
                        <p class="font-bold text-gray-900">{{ $item->name }}</p>
                        <p class="text-gray-500 text-sm mt-1">{{ $item->variant }}</p>
                    </td>
                    <td class="py-5 text-center align-top">{{ $item->quantity }}</td>
                    <td class="py-5 text-right align-top font-medium">{{ number_format($item->price, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Summary Section --}}
        <div class="w-full border-t-2 border-gray-200 pt-4 mb-10 space-y-3">
            
            {{-- Dòng Tổng tiền --}}
            <div class="flex justify-between text-sm font-bold text-gray-800">
                <span>Tổng tiền</span>
                <span>{{ number_format($order->subtotal, 0, ',', '.') }}</span>
            </div>
            
            <div class="flex justify-between text-sm font-bold text-gray-800">
                <span>Giá giảm</span>
                <span>{{ number_format($order->discount_amount, 0, ',', '.') }}</span>
            </div>
            
            <div class="flex justify-between text-sm font-bold text-gray-800">
                <span>Mã giảm giá</span>
                <span>{{ $order->discount_code }}</span>
            </div>

            {{-- Dòng Tổng thanh toán --}}
            <div class="flex justify-between items-center mt-4 pt-2">
                <span class="font-bold text-gray-900 text-xl">Tổng thanh toán (VND)</span>
                <span class="font-bold text-[#9F0712] text-2xl">{{ number_format($order->total, 0, ',', '.') }}</span>
            </div>
        </div>

        {{-- Quote / Note --}}
        <div class="bg-gray-50 p-6 rounded-lg mb-10 flex gap-3 text-gray-600 text-sm italic">
            <svg class="w-6 h-6 text-gray-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z" clip-rule="evenodd" /></svg>
            <div>
                <p class="mb-2">Vui lòng xuất hóa đơn trong vòng 7 ngày kể từ lúc mua hàng.</p>
                <p>Cám ơn bạn đã ghé thăm dịch vụ của chúng tôi.</p>
            </div>
        </div>

        {{-- Footer: Bank Info --}}
        <div class="mt-8">
            {{-- Header --}}
            <div class="flex items-center mb-6">
                <h4 class="uppercase text-xs font-bold text-gray-500 tracking-wider mr-4 whitespace-nowrap">Thông tin thanh toán</h4>
                <div class="flex-grow border-t border-gray-200"></div>
            </div>

            {{-- Content --}}
            <div class="flex flex-col md:flex-row justify-between items-start">
                
                {{-- Bên trái: Thông tin cá nhân --}}
                <div class="mb-6 md:mb-0">
                    <p class="font-bold text-gray-800 uppercase text-sm">{{ $bank_info->account_owner }}</p>
                    <p class="text-gray-500 text-sm mt-1">{{ $bank_info->address }}</p>
                    <p class="text-gray-500 text-sm">{{ $bank_info->phone }}</p>
                </div>

                {{-- Bên phải: Thông tin ngân hàng --}}
                <div class="flex flex-col md:flex-row md:items-center text-sm">
                    
                    {{-- Cột 1: Tên ngân hàng --}}
                    <div class="md:pr-8 mb-4 md:mb-0">
                        <p class="text-gray-500 text-xs font-medium mb-1">Tên ngân hàng</p>
                        <p class="font-bold text-gray-600 uppercase">{{ $bank_info->bank_name }}</p>
                    </div>

                    {{-- Cột 2: Mã Code --}}
                    <div class="md:px-8 md:border-l md:border-gray-200 mb-4 md:mb-0">
                        <p class="text-gray-500 text-xs font-medium mb-1">Mã code</p>
                        <p class="font-bold text-gray-600 uppercase">{{ $bank_info->bank_code }}</p>
                    </div>

                    {{-- Cột 3: Mã tài khoản --}}
                    <div class="md:pl-8 md:border-l md:border-gray-200">
                        <p class="text-gray-500 text-xs font-medium mb-1">Mã tài khoản</p>
                        <p class="font-bold text-gray-600">{{ $bank_info->account_number }}</p>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

@endsection