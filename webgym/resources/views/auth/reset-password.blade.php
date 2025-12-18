{{-- resources/views/auth/reset-password.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="w-full h-auto bg-white flex items-start justify-center pt-10 pb-22">
    
    <div class="w-full max-w-[1800px] mx-auto px-4 lg:px-8 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">

        {{-- Cột trái: Ảnh minh họa --}}
        <div class="hidden lg:block lg:col-span-7">
            <div class="overflow-hidden relative shadow-sm">
                <img src="{{ asset('images/login/welcome.png') }}" 
                     class="w-full h-[550px] object-cover"
                     alt="Reset Password Banner">
            </div>
        </div>

        {{-- Cột phải: Form đặt lại mật khẩu --}}
        <div class="w-full px-4 lg:px-12 lg:col-span-5">
            <h2 class="text-4xl font-extrabold mb-4 text-center bg-gradient-to-r from-[#0D47A1] to-[#42A5F5] bg-clip-text text-transparent pb-2">
                ĐẶT LẠI MẬT KHẨU
            </h2>
            
            <p class="text-gray-700 mb-8 text-center text-sm px-4 leading-relaxed">
                Vui lòng nhập mật khẩu mới cho tài khoản của bạn.<br>
                Hãy chọn mật khẩu mạnh để bảo mật tốt hơn.
            </p>

            {{-- Thông báo lỗi chung (nếu có lỗi token hoặc lỗi hệ thống) --}}
            @if ($errors->any())
                <div class="bg-red-50 text-red-600 px-4 py-3 rounded-lg mb-6 text-sm border border-red-100">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                {{-- Email --}}
                <div class="group">
                    <label class="block text-gray-700 text-sm mb-1 font-semibold">Email</label>
                    <input type="email" name="email" value="{{ old('email', $email ?? '') }}" readonly
                        class="w-full border-0 border-b border-gray-300 px-0 py-2 focus:ring-0 focus:border-[#1976D2] transition-colors bg-gray-50 text-gray-500 cursor-not-allowed"
                        required>
                </div>

                {{-- Mật khẩu mới --}}
                <div class="group">
                    <label class="block text-gray-700 text-sm mb-1 font-semibold">Mật khẩu mới</label>
                    <div class="relative">
                        <input id="password" type="password" name="password"
                            class="w-full border-0 border-b border-gray-300 px-0 py-2 focus:ring-0 focus:border-[#1976D2] transition-colors bg-transparent text-gray-800 placeholder-gray-400"
                            placeholder="********" required autofocus>
                        <button type="button" id="togglePassword" class="absolute right-0 bottom-2 text-gray-400 hover:text-[#1976D2] transition text-xs font-semibold uppercase">
                            Hiện
                        </button>
                    </div>
                </div>

                {{-- Xác nhận mật khẩu --}}
                <div class="group">
                    <label class="block text-gray-700 text-sm mb-1 font-semibold">Xác nhận mật khẩu</label>
                    <input type="password" name="password_confirmation"
                        class="w-full border-0 border-b border-gray-300 px-0 py-2 focus:ring-0 focus:border-[#1976D2] transition-colors bg-transparent text-gray-800 placeholder-gray-400"
                        placeholder="********" required>
                </div>

                {{-- Nút Submit --}}
                <div class="pt-4 flex justify-center">
                    <button type="submit" class="bg-[#1976D2] hover:bg-blue-600 text-white py-3 px-8 w-60 rounded-full font-bold shadow-lg shadow-blue-500/30 transition transform hover:-translate-y-0.5 cursor-pointer uppercase tracking-wider text-sm">
                        Cập nhật mật khẩu
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    // Script ẩn hiện mật khẩu (chỉ áp dụng cho ô Mật khẩu mới)
    document.getElementById('togglePassword')?.addEventListener('click', function () {
        const input = document.getElementById('password');
        const isPass = input.type === 'password';
        input.type = isPass ? 'text' : 'password';
        this.textContent = isPass ? 'Ẩn' : 'Hiện';
    });
</script>

<style>
    /* Đồng bộ CSS input autofill */
    input:-webkit-autofill,
    input:-webkit-autofill:hover, 
    input:-webkit-autofill:focus, 
    input:-webkit-autofill:active{
        -webkit-box-shadow: 0 0 0 30px white inset !important;
    }
    input:focus {
        outline: none !important;
        box-shadow: none !important;
    }
</style>

@endsection