@extends('user.layouts.user_dashboard')

@section('title', 'Hồ sơ cá nhân - GRYND')

{{-- AlpineJS --}}
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

@section('content')
<div class="font-open-sans">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-black font-montserrat">Hồ sơ của bạn</h1>
        <p class="text-sm text-gray-500 mt-1 font-open-sans">Quản lý thông tin cá nhân và cài đặt mật khẩu</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
        {{-- Main Content Column --}}
        <div class="md:col-span-12 space-y-8">

            {{-- SECTION 1: Avatar Card --}}
            <div class="bg-white rounded-2xl p-6 shadow-[0_4px_20px_rgba(0,0,0,0.05)] border border-gray-100 flex flex-col sm:flex-row items-center justify-between transition-shadow duration-300 hover:shadow-lg">
                <div class="flex items-center mb-4 sm:mb-0">
                    <div class="h-20 w-20 bg-gray-100 rounded-full flex-shrink-0 overflow-hidden border-2 border-white shadow-sm relative group">
                        <img src="{{ Auth::user()->image_url ?? 'https://via.placeholder.com/150' }}" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-110" alt="Avatar">
                    </div>
                    <div class="ml-5">
                        <h3 class="text-xl font-bold text-[#0D47A1] font-montserrat">{{ Auth::user()->full_name ?? 'Tên người dùng' }}</h3>
                        <p class="text-[#333333]/70 text-sm">{{ Auth::user()->email ?? 'email@example.com' }}</p>
                        <span class="inline-block mt-1 px-3 py-0.5 rounded-full bg-blue-50 text-blue-600 text-xs font-bold border border-blue-100">
                            Thành viên
                        </span>
                    </div>
                </div>
                <button type="button" class="w-full sm:w-auto px-6 py-2.5 bg-[#1976D2] hover:bg-[#0D47A1]/90 text-white font-semibold rounded-full transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5 flex items-center justify-center gap-2 text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                    Tải ảnh mới
                </button>
            </div>

            {{-- SECTION 2: Thông tin cá nhân --}}
            <div class="bg-white rounded-2xl p-8 shadow-[0_4px_20px_rgba(0,0,0,0.05)] border border-gray-100">
                <div class="flex items-center gap-3 mb-6 border-b border-gray-100 pb-4">
                    <div class="p-2 bg-blue-50 rounded-lg text-[#1976D2]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <h2 class="text-xl font-bold text-[#0D47A1] font-montserrat">Thông tin cá nhân</h2>
                </div>

                @if(session('success'))
                    <div class="bg-green-50 text-green-700 px-4 py-3 rounded-xl mb-6 border border-green-200 flex items-center gap-2 text-sm font-medium">
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 gap-y-6 gap-x-8 sm:grid-cols-2">
                        
                        <div class="space-y-1.5">
                            <label for="full_name" class="block text-sm font-bold text-[#333333]/80">Họ và tên</label>
                            <input type="text" name="full_name" id="full_name" value="{{ Auth::user()->full_name }}" 
                                class="block w-full border-gray-200 rounded-lg shadow-sm focus:ring-[#1976D2] focus:border-[#1976D2] text-sm px-4 py-3 bg-gray-50/50 transition-colors">
                        </div>

                        <div class="space-y-1.5">
                            <label for="birth_date" class="block text-sm font-bold text-[#333333]/80">Ngày sinh</label>
                            <input type="date" name="birth_date" id="birth_date" value="{{ Auth::user()->birth_date }}" 
                                class="block w-full border-gray-200 rounded-lg shadow-sm focus:ring-[#1976D2] focus:border-[#1976D2] text-sm px-4 py-3 bg-gray-50/50 text-gray-700">
                        </div>

                        <div class="space-y-1.5">
                            <label for="gender" class="block text-sm font-bold text-[#333333]/80">Giới tính</label>
                            <div class="relative">
                                <select name="gender" id="gender" class="block w-full border-gray-200 rounded-lg shadow-sm focus:ring-[#1976D2] focus:border-[#1976D2] text-sm px-4 py-3 bg-gray-50/50 appearance-none text-gray-700">
                                    <option value="">Chọn giới tính</option>
                                    <option value="Nam" {{ Auth::user()->gender === 'Nam' ? 'selected' : '' }}>Nam</option>
                                    <option value="Nữ" {{ Auth::user()->gender === 'Nữ' ? 'selected' : '' }}>Nữ</option>
                                    <option value="Khác" {{ Auth::user()->gender === 'Khác' ? 'selected' : '' }}>Khác</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label for="phone" class="block text-sm font-bold text-[#333333]/80">Số điện thoại</label>
                            <input type="tel" name="phone" id="phone" value="{{ Auth::user()->phone }}" placeholder="012 345 6789" 
                                class="block w-full border-gray-200 rounded-lg shadow-sm focus:ring-[#1976D2] focus:border-[#1976D2] text-sm px-4 py-3 bg-gray-50/50">
                        </div>

                        <div class="sm:col-span-2 space-y-1.5">
                            <label for="email" class="block text-sm font-bold text-[#333333]/80">Email</label>
                            <input type="email" name="email" id="email" value="{{ Auth::user()->email }}"
                                class="block w-full border-gray-200 rounded-lg shadow-sm focus:ring-[#1976D2] focus:border-[#1976D2] text-sm px-4 py-3 bg-gray-50/50">
                        </div>

                        <div class="sm:col-span-2 space-y-1.5">
                            <label for="address" class="block text-sm font-bold text-[#333333]/80">Địa chỉ</label>
                            <input type="text" name="address" id="address" value="{{ Auth::user()->address }}" placeholder="Nhập địa chỉ của bạn" 
                                class="block w-full border-gray-200 rounded-lg shadow-sm focus:ring-[#1976D2] focus:border-[#1976D2] text-sm px-4 py-3 bg-gray-50/50">
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end">
                        <button type="submit" class="px-8 py-3 bg-[#1976D2] hover:bg-[#0D47A1]/90 text-white font-bold rounded-full transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5 text-sm uppercase tracking-wide">
                            Lưu thay đổi
                        </button>
                    </div>
                </form>
            </div>

            {{-- SECTION 3: Đổi mật khẩu --}}
            <div class="bg-white rounded-2xl p-8 shadow-[0_4px_20px_rgba(0,0,0,0.05)] border border-gray-100">
                <div class="flex items-center gap-3 mb-6 border-b border-gray-100 pb-4">
                    <div class="p-2 bg-red-50 rounded-lg text-red-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-[#0D47A1] font-montserrat">Bảo mật & Mật khẩu</h3>
                </div>

                <form action="{{ route('profile.change-password') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 gap-6">
                        <div class="space-y-1.5">
                            <label for="current_password" class="block text-sm font-bold text-[#333333]/80">Mật khẩu hiện tại</label>
                            <input type="password" name="current_password" id="current_password" placeholder="••••••••" 
                                class="block w-full border-gray-200 rounded-lg shadow-sm focus:ring-[#1976D2] focus:border-[#1976D2] text-sm px-4 py-3 bg-gray-50/50">
                            @error('current_password')
                                <p class="text-[#D32F2F] text-xs mt-1 font-semibold flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div class="space-y-1.5">
                                <label for="password" class="block text-sm font-bold text-[#333333]/80">Mật khẩu mới</label>
                                <input type="password" name="password" id="password" placeholder="••••••••" 
                                    class="block w-full border-gray-200 rounded-lg shadow-sm focus:ring-[#1976D2] focus:border-[#1976D2] text-sm px-4 py-3 bg-gray-50/50">
                                @error('password')
                                    <p class="text-[#D32F2F] text-xs mt-1 font-semibold flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            
                            <div class="space-y-1.5">
                                <label for="password_confirmation" class="block text-sm font-bold text-[#333333]/80">Xác nhận mật khẩu mới</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" placeholder="••••••••" 
                                    class="block w-full border-gray-200 rounded-lg shadow-sm focus:ring-[#1976D2] focus:border-[#1976D2] text-sm px-4 py-3 bg-gray-50/50">
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end">
                        <button type="submit" class="px-8 py-3 bg-white border border-[#1976D2] text-[#1976D2] hover:bg-blue-50 font-bold rounded-full transition-all shadow-sm hover:shadow-md transform hover:-translate-y-0.5 text-sm uppercase tracking-wide">
                            Cập nhật mật khẩu
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection