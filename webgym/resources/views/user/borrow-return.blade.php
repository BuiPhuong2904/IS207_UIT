@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-12 gap-8">
            <!-- Sidebar -->
            <aside class="col-span-12 md:col-span-3">
                <div class="bg-white rounded-lg shadow p-6 sticky top-6">
                    <div class="flex items-center mb-6">
                        <img src="/images/logo.png" alt="logo" class="h-10 w-10 mr-3">
                        <span class="text-xl font-bold text-blue-600">GRYND</span>
                    </div>

                    <nav class="text-sm space-y-2">
                        <a href="{{ route('profile') ?? '#' }}" class="flex items-center px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-50">
                            <span class="mr-3">👤</span>
                            Hồ sơ
                        </a>
                        <a href="#" class="flex items-center px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-50">
                            <span class="mr-3">🏷️</span>
                            Gói tập đã mua
                        </a>
                        <a href="#" class="flex items-center px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-50">
                            <span class="mr-3">📚</span>
                            Lớp học đã đăng ký
                        </a>
                        <a href="#" class="flex items-center px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-50">
                            <span class="mr-3">🧾</span>
                            Lịch sử đơn hàng
                        </a>
                        <a href="#" class="flex items-center px-3 py-2 rounded-lg bg-blue-50 text-blue-600 font-medium">
                            <span class="mr-3">🔁</span>
                            Lịch sử mượn trả
                        </a>
                    </nav>
                </div>
            </aside>

            <!-- Main content -->
            <main class="col-span-12 md:col-span-9">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">Lịch sử mượn trả của bạn</h2>
                            <p class="text-sm text-gray-500">Quản lý lịch sử mượn trả</p>
                        </div>
                        <div class="hidden sm:block">
                            <!-- placeholder for controls -->
                        </div>
                    </div>

                    <!-- Tabs -->
                    <div class="mb-6">
                        <div class="bg-gray-100 rounded-full inline-flex p-1">
                            <button class="px-6 py-2 rounded-full bg-white text-blue-600 font-medium">Tất cả</button>
                            <button class="px-6 py-2 rounded-full text-gray-600">Đang mượn</button>
                            <button class="px-6 py-2 rounded-full text-gray-600">Đã trả</button>
                        </div>
                    </div>

                    <!-- Rental card example -->
                    <div class="space-y-6">
                        <!-- Card 1 -->
                        <div class="border border-gray-100 rounded-xl p-6 bg-white">
                            <div class="flex items-start justify-between pb-4 border-b border-gray-100 mb-4">
                                <div>
                                    <h3 class="text-sm text-gray-500">Mã giao dịch mượn trả: <span class="font-medium text-gray-800">#0001</span></h3>
                                    <p class="text-xs text-gray-400 mt-1">Ngày mượn: 22/11/2025</p>
                                </div>
                                <div class="text-sm text-gray-600">Ngày mượn: <span class="font-medium">22/11/2025</span></div>
                            </div>

                            <div class="grid grid-cols-12 gap-4 items-center">
                                <div class="col-span-12 sm:col-span-3">
                                    <img src="/images/products/sample1.jpg" alt="item" class="w-full h-24 object-cover rounded">
                                </div>
                                <div class="col-span-12 sm:col-span-7">
                                    <div class="text-sm text-gray-700">
                                        <div class="font-medium">Tạ tập Gym</div>
                                        <div class="text-xs text-gray-500 mt-1">Số lượng: x1</div>
                                        <div class="text-xs text-gray-500">Chi nhánh: Võ Thị Sáu</div>
                                    </div>
                                </div>
                                <div class="col-span-12 sm:col-span-2 text-right">
                                    <div class="text-sm text-gray-700">149.000 VND</div>
                                </div>
                            </div>

                            <div class="mt-4 grid grid-cols-12 gap-4 items-center">
                                <div class="col-span-12 sm:col-span-3">
                                    <img src="/images/products/sample2.jpg" alt="item2" class="w-full h-24 object-cover rounded">
                                </div>
                                <div class="col-span-12 sm:col-span-7">
                                    <div class="text-sm text-gray-700">
                                        <div class="font-medium">Đồ tập thể thao</div>
                                        <div class="text-xs text-gray-500 mt-1">Số lượng: x2</div>
                                        <div class="text-xs text-gray-500">Chi nhánh: Võ Thị Sáu</div>
                                    </div>
                                </div>
                                <div class="col-span-12 sm:col-span-2 text-right">
                                    <div class="text-sm text-gray-700">156.000 VND</div>
                                </div>
                            </div>

                            <div class="mt-6 flex items-center justify-between text-sm">
                                <div class="text-gray-600">Trạng thái: <span class="text-orange-500 font-medium">Đang mượn</span></div>
                                <div class="text-red-600 font-bold">Tổng tiền: <span class="text-red-600">305.000 VND</span></div>
                            </div>
                        </div>

                        <!-- Card 2 (returned) -->
                        <div class="border border-gray-100 rounded-xl p-6 bg-white">
                            <div class="flex items-start justify-between pb-4 border-b border-gray-100 mb-4">
                                <div>
                                    <h3 class="text-sm text-gray-500">Mã giao dịch mượn trả: <span class="font-medium text-gray-800">#0002</span></h3>
                                    <p class="text-xs text-gray-400 mt-1">Ngày mượn: 22/11/2025</p>
                                </div>
                                <div class="text-sm text-gray-600">Ngày mượn: <span class="font-medium">22/11/2025</span></div>
                            </div>

                            <div class="grid grid-cols-12 gap-4 items-center">
                                <div class="col-span-12 sm:col-span-3">
                                    <img src="/images/products/sample1.jpg" alt="item" class="w-full h-24 object-cover rounded">
                                </div>
                                <div class="col-span-12 sm:col-span-7">
                                    <div class="text-sm text-gray-700">
                                        <div class="font-medium">Tạ tập Gym</div>
                                        <div class="text-xs text-gray-500 mt-1">Số lượng: x1</div>
                                        <div class="text-xs text-gray-500">Chi nhánh: Võ Thị Sáu</div>
                                    </div>
                                </div>
                                <div class="col-span-12 sm:col-span-2 text-right">
                                    <div class="text-sm text-gray-700">149.000 VND</div>
                                </div>
                            </div>

                            <div class="mt-4 grid grid-cols-12 gap-4 items-center">
                                <div class="col-span-12 sm:col-span-3">
                                    <img src="/images/products/sample2.jpg" alt="item2" class="w-full h-24 object-cover rounded">
                                </div>
                                <div class="col-span-12 sm:col-span-7">
                                    <div class="text-sm text-gray-700">
                                        <div class="font-medium">Đồ tập thể thao</div>
                                        <div class="text-xs text-gray-500 mt-1">Số lượng: x2</div>
                                        <div class="text-xs text-gray-500">Chi nhánh: Võ Thị Sáu</div>
                                    </div>
                                </div>
                                <div class="col-span-12 sm:col-span-2 text-right">
                                    <div class="text-sm text-gray-700">156.000 VND</div>
                                </div>
                            </div>

                            <div class="mt-6 flex items-center justify-between text-sm">
                                <div class="text-gray-600">Trạng thái: <span class="text-green-600 font-medium">Đã trả</span></div>
                                <div class="text-red-600 font-bold">Tổng tiền: <span class="text-red-600">305.000 VND</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</div>

@endsection
