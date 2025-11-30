{{-- resources/views/auth/forget-password.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="w-full min-h-screen bg-white py-10">
    <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">

        <!-- LEFT IMAGE -->
        <div class="hidden lg:block">
            <div class="rounded-xl overflow-hidden shadow-lg">
                <img src="{{ asset('images/login/welcome.png') }}" 
                     class="w-full h-[500px] object-cover"
                     alt="Welcome Banner">
            </div>
        </div>

        <!-- RIGHT FORGET PASSWORD FORM -->
        <div class="w-full px-6 lg:px-10">
            <h2 class="text-3xl font-bold text-[#0D47A1] mb-2">Quên mật khẩu</h2>
            <p class="text-gray-500 mb-6">Nhập email bạn đã đăng ký. Chúng tôi sẽ gửi mã xác minh gồm 6 số để đặt lại mật khẩu.</p>

            @if(session('error'))
                <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4 text-sm">{{ session('error') }}</div>
            @endif

            @if(session('success'))
                <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4 text-sm">{{ session('success') }}</div>
            @endif

            <form action="{{ route('forget-password.send') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-[#1976D2] focus:outline-none"
                        placeholder="johndoe@email.com" required>
                    @error('email')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-[#3484d4] to-[#42A5F5] text-white py-3 rounded-full font-semibold shadow-md transition">NHẬN MÃ NGAY</button>

                <div class="text-center text-sm text-gray-600">
                    Bạn đã có tài khoản? <a href="{{ route('login') }}" class="text-[#1976D2] hover:underline font-medium">ĐĂNG NHẬP</a>
                </div>
            </form>
        </div>
    </div>
    
</div>

@endsection
