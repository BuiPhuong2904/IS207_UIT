@extends('layouts.ad_layout')

@section('title', 'Dashboard')

@section('content')

{{-- 1. KHỞI TẠO DỮ LIỆU GIẢ (MOCK DATA) CHO BIỂU ĐỒ --}}
@php
    // Dữ liệu giả lập cho Biểu đồ 1: Doanh thu 12 tháng (Đơn vị: VNĐ)
    // Bao gồm tiền bán gói tập + bán hàng
    $revenueData = [
        'labels' => ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
        'data'   => [45000000, 52000000, 48000000, 61000000, 55000000, 72000000, 68000000, 80000000, 75000000, 92000000, 88000000, 105000000]
    ];
    $totalRevenue = array_sum($revenueData['data']); // Tính tổng để hiển thị lên Card

    // Dữ liệu giả lập cho Biểu đồ 2: Cơ cấu doanh thu
    $structureData = [
        'labels' => ['Bán gói tập (Membership)', 'Bán lẻ sản phẩm', 'Dịch vụ khác'],
        'data'   => [550000000, 250000000, 41000000], // Tổng doanh thu cả năm chia theo nguồn
    ];

    // Dữ liệu giả lập cho Biểu đồ 3: Tỷ lệ gói tập được đăng ký
    $packageData = [
        'labels' => ['Gói 1 Tháng', 'Gói 3 Tháng', 'Gói 6 Tháng', 'Gói PT 1-1'],
        'data'   => [52.1, 22.8, 13.9, 11.2], // Đơn vị %
    ];

    // Dữ liệu giả lập cho Biểu đồ 4: Tăng trưởng khách hàng mới (Số người)
    $newMemberData = [
        'labels' => ['T1', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'T8', 'T9', 'T10', 'T11', 'T12'],
        'data'   => [15, 22, 18, 30, 25, 40, 35, 45, 42, 55, 60, 75],
    ];
    $totalNewMembers = array_sum($newMemberData['data']);
    $totalOrders = 2318; // Số giả định
    $totalClasses = 48;  // Số giả định
@endphp

<div class="p-1 min-h-screen font-open-sans">
    
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Tổng quan</h1>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-blue-100 p-6 rounded-2xl shadow-sm border border-blue-100 transition hover:shadow-md">
            <p class="text-sm font-medium text-gray-500">Tổng Doanh thu</p>
            <div class="flex items-end justify-between mt-2">
                <h3 class="text-2xl font-bold text-gray-800">{{ number_format($totalRevenue) }} VND</h3>
            </div>
        </div>
        <div class="bg-blue-100 p-6 rounded-2xl shadow-sm border border-blue-100 transition hover:shadow-md">
            <p class="text-sm font-medium text-gray-500">Lớp học đang mở</p>
            <div class="flex items-end justify-between mt-2">
                <h3 class="text-2xl font-bold text-gray-800">{{ $totalClasses }}</h3>
            </div>
        </div>
        <div class="bg-blue-100 p-6 rounded-2xl shadow-sm border border-blue-100 transition hover:shadow-md">
            <p class="text-sm font-medium text-gray-500">Học viên</p>
            <div class="flex items-end justify-between mt-2">
                <h3 class="text-2xl font-bold text-gray-800">{{ $totalNewMembers }}</h3>
            </div>
        </div>
        <div class="bg-blue-100 p-6 rounded-2xl shadow-sm border border-blue-100 transition hover:shadow-md">
            <p class="text-sm font-medium text-gray-500">Tổng đơn hàng</p>
            <div class="flex items-end justify-between mt-2">
                <h3 class="text-2xl font-bold text-gray-800">{{ number_format($totalOrders) }}</h3>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm mb-8 border border-gray-100">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg font-bold text-gray-800">Tổng doanh thu sản phẩm & Gói tập</h2>
            <select class="text-sm border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                <option>Năm 2025</option>
            </select>
        </div>
        <div class="relative h-80 w-full">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <h2 class="text-lg font-bold text-gray-800 mb-6">Cơ cấu doanh thu</h2>
            <div class="flex flex-col md:flex-row items-center justify-center">
                <div class="w-full md:w-1/2 h-64 relative">
                    <canvas id="revenueStructureChart"></canvas>
                </div>
                <div class="w-full md:w-1/2 mt-6 md:mt-0 md:pl-8 space-y-4">
                    @foreach($structureData['labels'] as $index => $label)
                    <div class="flex justify-between items-center text-sm">
                        <div class="flex items-center">
                            <span class="w-3 h-3 rounded-full mr-3" id="legend-color-struct-{{$index}}"></span>
                            <span class="text-gray-600">{{ $label }}</span>
                        </div>
                        <span class="font-bold text-gray-800">{{ number_format($structureData['data'][$index]/array_sum($structureData['data'])*100, 1) }}%</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <h2 class="text-lg font-bold text-gray-800 mb-6">Tỷ lệ các gói tập được đăng ký</h2>
            <div class="flex flex-col md:flex-row items-center justify-center">
                <div class="w-full md:w-1/2 h-64 relative">
                    <canvas id="packageChart"></canvas>
                </div>
                <div class="w-full md:w-1/2 mt-6 md:mt-0 md:pl-8 space-y-4">
                    @foreach($packageData['labels'] as $index => $label)
                    <div class="flex justify-between items-center text-sm">
                        <div class="flex items-center">
                            <span class="w-3 h-3 rounded-full mr-3" id="legend-color-pkg-{{$index}}"></span>
                            <span class="text-gray-600">{{ $label }}</span>
                        </div>
                        <span class="font-bold text-gray-800">{{ $packageData['data'][$index] }}%</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <h2 class="text-lg font-bold text-gray-800 mb-6">Tăng trưởng khách hàng mới</h2>
        <div class="relative h-72 w-full">
            <canvas id="newUsersChart"></canvas>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // --- CẤU HÌNH MÀU SẮC MỚI ---
    const colors = {
        primary:    '#3B82F6', // Xanh dương (Blue 500)
        secondary:  '#1F2937', // Xám đậm (Gray 800)
        success:    '#10B981', // Xanh lá (Emerald 500)
        warning:    '#F59E0B', // Vàng cam (Amber 500)
        info:       '#06B6D4', // Xanh ngọc (Cyan 500)
        purple:     '#8B5CF6', // Tím (Violet 500)
        lightBlue:  '#93C5FD', // Xanh nhạt (Blue 300)
        
        // Bảng màu cho biểu đồ tròn
        piePalette: [
            '#3B82F6', // Blue 
            '#2DD4BF', // Teal 
            '#F472B6', // Pink 
            '#A78BFA'  // Violet
        ]
    };

    Chart.defaults.font.family = "'Inter', sans-serif";
    Chart.defaults.color = '#6b7280';

    // 1. BIỂU ĐỒ ĐƯỜNG (Doanh thu)
    const ctxRevenue = document.getElementById('revenueChart').getContext('2d');
    const gradientRevenue = ctxRevenue.createLinearGradient(0, 0, 0, 400);
    gradientRevenue.addColorStop(0, 'rgba(59, 130, 246, 0.2)'); 
    gradientRevenue.addColorStop(1, 'rgba(59, 130, 246, 0)');

    new Chart(ctxRevenue, {
        type: 'line',
        data: {
            labels: @json($revenueData['labels']),
            datasets: [{
                label: 'Doanh thu',
                data: @json($revenueData['data']),
                borderColor: colors.primary,
                backgroundColor: gradientRevenue,
                borderWidth: 2,
                fill: true,
                pointRadius: 0,
                pointHoverRadius: 6, // Khi hover trúng thì hiện to lên
                pointHoverBackgroundColor: colors.primary,
                pointHoverBorderColor: '#fff',
                pointHoverBorderWidth: 2,
                // Tăng vùng nhận diện click/hover
                hitRadius: 30, 
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            // --- FIX LỖI HOVER ---
            interaction: {
                mode: 'index',
                intersect: false,
            },

            plugins: { 
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(31, 41, 55, 0.9)', 
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    padding: 10,
                    cornerRadius: 8,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(context.raw);
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { borderDash: [4, 4], color: '#f3f4f6', drawBorder: false },
                    ticks: { callback: function(value) { return value / 1000000 + ' tr'; }, color: '#9CA3AF' }
                },
                x: { 
                    grid: { display: false, drawBorder: false },
                    ticks: { color: '#9CA3AF' }
                }
            }
        }
    });

    // 2. BIỂU ĐỒ TRÒN 1 (Cơ cấu doanh thu)
    const structureColors = [colors.primary, colors.info, colors.purple];

    const ctxStructure = document.getElementById('revenueStructureChart').getContext('2d');
    new Chart(ctxStructure, {
        type: 'pie',
        data: {
            labels: @json($structureData['labels']),
            datasets: [{
                data: @json($structureData['data']),
                backgroundColor: structureColors,
                borderWidth: 2,
                borderColor: '#ffffff',
                hoverOffset: 10
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            responsive: true,
            maintainAspectRatio: false,
        }
    });
    
    // Cập nhật màu cho Legend (Chú thích) bên cạnh
    @foreach($structureData['labels'] as $index => $label)
        document.getElementById('legend-color-struct-{{$index}}').style.backgroundColor = structureColors[{{$index}} % structureColors.length];
    @endforeach

    // 3. BIỂU ĐỒ TRÒN 2 (Tỷ lệ gói tập)
    const ctxPackage = document.getElementById('packageChart').getContext('2d');
    new Chart(ctxPackage, {
        type: 'pie',
        data: {
            labels: @json($packageData['labels']),
            datasets: [{
                data: @json($packageData['data']),
                backgroundColor: colors.piePalette,
                borderWidth: 2,
                borderColor: '#ffffff',
                hoverOffset: 10
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            responsive: true,
            maintainAspectRatio: false,
        }
    });
    
    // màu cho Legend (Chú thích) bên cạnh
    @foreach($packageData['labels'] as $index => $label)
        document.getElementById('legend-color-pkg-{{$index}}').style.backgroundColor = colors.piePalette[{{$index}} % colors.piePalette.length];
    @endforeach

    // 4. BIỂU ĐỒ CỘT (Khách hàng mới)
    const ctxNewUsers = document.getElementById('newUsersChart').getContext('2d');
    new Chart(ctxNewUsers, {
        type: 'bar',
        data: {
            labels: @json($newMemberData['labels']),
            datasets: [{
                label: 'Thành viên mới',
                data: @json($newMemberData['data']),
                backgroundColor: colors.lightBlue, // Màu cột nhạt
                hoverBackgroundColor: colors.primary, // Hover đậm lên
                borderRadius: 4,
                barThickness: 20,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,

                },
                x: { 
                    grid: { display: false, drawBorder: false },
                    ticks: { color: '#9CA3AF' }
                }
            }
        }
    });
</script>

@endsection
