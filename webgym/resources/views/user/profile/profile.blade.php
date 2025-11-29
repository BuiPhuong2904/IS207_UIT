@extends('layouts.app')

@section('content')
<div class="bg-gray-100 min-h-screen py-10">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
            <div class="md:col-span-3">
                <div class="flex items-center mb-8 pl-2">
                    <svg class="h-8 w-8 text-blue-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    <span class="text-2xl font-bold text-gray-800">GRYND</span>
                </div>

                <nav class="space-y-2">
                    <a href="{{ url('/profile') }}" class="bg-blue-100 text-blue-700 group flex items-center px-4 py-3 text-sm font-medium rounded-lg">
                        <svg class="text-blue-600 mr-3 flex-shrink-0 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Hồ sơ
                    </a>

                    <a href="#" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-4 py-3 text-sm font-medium rounded-lg">
                        <svg class="text-gray-400 group-hover:text-gray-500 mr-3 flex-shrink-0 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        Gói tập đã mua
                    </a>

                    <a href="#" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-4 py-3 text-sm font-medium rounded-lg">
                        <svg class="text-gray-400 group-hover:text-gray-500 mr-3 flex-shrink-0 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M12 14l9-5-9-5-9 5 9 5z" />
                            <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                        </svg>
                        Lớp học đã đăng ký
                    </a>

                    <a href="#" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-4 py-3 text-sm font-medium rounded-lg">
                        <svg class="text-gray-400 group-hover:text-gray-500 mr-3 flex-shrink-0 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Lịch sử đơn hàng
                    </a>

                     <a href="#" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-4 py-3 text-sm font-medium rounded-lg">
                        <svg class="text-gray-400 group-hover:text-gray-500 mr-3 flex-shrink-0 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Lịch sử mượn trả
                    </a>
                </nav>
            </div>

            <div class="md:col-span-9">
                 <div class="mb-6">
                    <h1 class="text-2xl font-bold text-gray-900">Hồ sơ của bạn</h1>
                    <p class="mt-1 text-sm text-gray-600">Quản lý thông tin cá nhân và cài đặt mật khẩu</p>
                </div>

                <div class="bg-white shadow-sm rounded-lg p-6 mb-6 flex flex-col sm:flex-row items-center justify-between">
                    <div class="flex items-center mb-4 sm:mb-0">
                        <div class="h-16 w-16 bg-gray-200 rounded-full flex-shrink-0 overflow-hidden">
                            <img src="{{ Auth::user()->image_url ?? 'https://via.placeholder.com/150' }}" class="h-full w-full object-cover" alt="Avatar">
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-bold text-gray-900">{{ Auth::user()->full_name ?? 'Tên người dùng' }}</h3>
                            <p class="text-gray-600 text-sm">{{ Auth::user()->email ?? 'email@example.com' }}</p>
                        </div>
                    </div>
                    <button type="button" class="w-full sm:w-auto bg-blue-600 text-white px-6 py-2 rounded-full hover:bg-blue-700 font-medium text-sm flex items-center justify-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                        Tải ảnh lên
                    </button>
                </div>


                <div class="bg-white shadow-sm rounded-lg p-6 mb-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Thông tin cá nhân</h2>

                    @if(session('success'))
                        <div class="bg-green-50 text-green-700 px-4 py-3 rounded mb-6 border-l-4 border-green-500">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 gap-y-6 gap-x-6 sm:grid-cols-2">
                            <div>
                                <label for="full_name" class="block text-sm font-medium text-gray-700 mb-1">Họ và tên</label>
                                <input type="text" name="full_name" id="full_name" value="{{ Auth::user()->full_name }}" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm px-4 py-3 border">
                            </div>
                            <div>
                                <label for="birth_date" class="block text-sm font-medium text-gray-700 mb-1">Ngày sinh</label>
                                <input type="date" name="birth_date" id="birth_date" value="{{ Auth::user()->birth_date }}" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm px-4 py-3 border text-gray-500">
                            </div>
                            <div>
                                <label for="gender" class="block text-sm font-medium text-gray-700 mb-1">Giới tính</label>
                                <select name="gender" id="gender" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm px-4 py-3 border text-gray-500">
                                    <option value="">Chọn giới tính</option>
                                    <option value="Nam" {{ Auth::user()->gender === 'Nam' ? 'selected' : '' }}>Nam</option>
                                    <option value="Nữ" {{ Auth::user()->gender === 'Nữ' ? 'selected' : '' }}>Nữ</option>
                                    <option value="Khác" {{ Auth::user()->gender === 'Khác' ? 'selected' : '' }}>Khác</option>
                                </select>
                            </div>
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Số điện thoại</label>
                                <input type="tel" name="phone" id="phone" value="{{ Auth::user()->phone }}" placeholder="012 345 6789" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm px-4 py-3 border">
                            </div>
                            <div class="sm:col-span-2">
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input type="email" name="email" id="email" value="{{ Auth::user()->email }}" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm px-4 py-3 border">
                            </div>
                            <div class="sm:col-span-2">
                                <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Địa chỉ</label>
                                <input type="text" name="address" id="address" value="{{ Auth::user()->address }}" placeholder="123 Bình Nguyên Vô Tận" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm px-4 py-3 border">
                            </div>
                        </div>

                        <div class="mt-8 flex justify-end">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-6 rounded-full font-medium text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Lưu thay đổi
                            </button>
                        </div>
                    </form>
                </div>


                <div class="bg-white shadow-sm rounded-lg p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Thay đổi mật khẩu</h3>
                    <form action="{{ route('profile.change-password') }}" method="POST" class="space-y-6">
                        @csrf
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Nhập mật khẩu cũ</label>
                            <input type="password" name="current_password" id="current_password" placeholder="matkhau" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm px-4 py-3 border">
                            @error('current_password')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Nhập mật khẩu mới</label>
                            <input type="password" name="password" id="password" placeholder="matkhau" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm px-4 py-3 border">
                            @error('password')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Nhập lại mật khẩu mới</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" placeholder="matkhau" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm px-4 py-3 border">
                        </div>

                         <div class="mt-8 flex justify-end">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-6 rounded-full font-medium text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Cập nhật mật khẩu
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection