@extends('layouts.ad_layout')

@section('title', 'Dashboard')

@section('content')

<div class="p-1 min-h-screen font-open-sans">
    
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Tổng quan</h1>
    </div>

    {{-- CÁC CARD THỐNG KÊ --}}
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
            <p class="text-sm font-medium text-gray-500">Học viên mới (Năm nay)</p>
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

    {{-- BIỂU ĐỒ DOANH THU --}}
    <div class="bg-white p-6 rounded-2xl shadow-sm mb-8 border border-gray-100">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg font-bold text-gray-800">Tổng doanh thu sản phẩm & Gói tập</h2>
            <select class="text-sm border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                <option>Năm {{ date('Y') }}</option>
            </select>
        </div>
        <div class="relative h-80 w-full">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        
        {{-- BIỂU ĐỒ CƠ CẤU DOANH THU --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <h2 class="text-lg font-bold text-gray-800 mb-6">Cơ cấu doanh thu</h2>
            <div class="flex flex-col md:flex-row items-center justify-center">
                <div class="w-full md:w-1/2 h-64 relative">
                    <canvas id="revenueStructureChart"></canvas>
                </div>
                <div class="w-full md:w-1/2 mt-6 md:mt-0 md:pl-8 space-y-4">
                    @php
                        $totalStructure = array_sum($structureData['data']);
                    @endphp

                    @foreach($structureData['labels'] as $index => $label)
                    <div class="flex justify-between items-center text-sm">
                        <div class="flex items-center">
                            <span class="w-3 h-3 rounded-full mr-3" id="legend-color-struct-{{$index}}"></span>
                            <span class="text-gray-600">{{ $label }}</span>
                        </div>
                        {{-- FIX LỖI CHIA CHO 0 Ở ĐÂY --}}
                        <span class="font-bold text-gray-800">
                            {{ $totalStructure > 0 ? number_format($structureData['data'][$index] / $totalStructure * 100, 1) : 0 }}%
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- BIỂU ĐỒ TỶ LỆ GÓI TẬP --}}
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
                        {{-- Dữ liệu này controller đã tính sẵn % rồi nên chỉ việc hiện --}}
                        <span class="font-bold text-gray-800">{{ $packageData['data'][$index] }}%</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- BIỂU ĐỒ TĂNG TRƯỞNG KHÁCH HÀNG --}}
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <h2 class="text-lg font-bold text-gray-800 mb-6">Tăng trưởng khách hàng mới</h2>
        <div class="relative h-72 w-full">
            <canvas id="newUsersChart"></canvas>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // --- CẤU HÌNH MÀU SẮC ---
    const colors = {
        primary:    '#3B82F6', 
        secondary:  '#1F2937', 
        success:    '#10B981', 
        warning:    '#F59E0B', 
        info:       '#06B6D4', 
        purple:     '#8B5CF6', 
        lightBlue:  '#93C5FD', 
        piePalette: ['#3B82F6', '#2DD4BF', '#F472B6', '#A78BFA']
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
                pointHoverRadius: 6,
                pointHoverBackgroundColor: colors.primary,
                pointHoverBorderColor: '#fff',
                pointHoverBorderWidth: 2,
                hitRadius: 30, 
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
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
    
    // Kiểm tra nếu không có dữ liệu thì không render chart để tránh lỗi
    @if(array_sum($structureData['data']) > 0)
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
        
        // Màu cho Legend
        @foreach($structureData['labels'] as $index => $label)
            const legendStruct{{$index}} = document.getElementById('legend-color-struct-{{$index}}');
            if(legendStruct{{$index}}) legendStruct{{$index}}.style.backgroundColor = structureColors[{{$index}} % structureColors.length];
        @endforeach
    @endif

    // 3. BIỂU ĐỒ TRÒN 2 (Tỷ lệ gói tập)
    const ctxPackage = document.getElementById('packageChart').getContext('2d');
    
    // Kiểm tra dữ liệu
    @if(array_sum($packageData['data']) > 0)
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
        
        // Màu cho Legend
        @foreach($packageData['labels'] as $index => $label)
             const legendPkg{{$index}} = document.getElementById('legend-color-pkg-{{$index}}');
             if(legendPkg{{$index}}) legendPkg{{$index}}.style.backgroundColor = colors.piePalette[{{$index}} % colors.piePalette.length];
        @endforeach
    @endif

    // 4. BIỂU ĐỒ CỘT (Khách hàng mới)
    const ctxNewUsers = document.getElementById('newUsersChart').getContext('2d');
    new Chart(ctxNewUsers, {
        type: 'bar',
        data: {
            labels: @json($newMemberData['labels']),
            datasets: [{
                label: 'Thành viên mới',
                data: @json($newMemberData['data']),
                backgroundColor: colors.lightBlue,
                hoverBackgroundColor: colors.primary,
                borderRadius: 4,
                barThickness: 55,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true },
                x: { grid: { display: false, drawBorder: false }, ticks: { color: '#9CA3AF' } }
            }
        }
    });
</script>

@endsection