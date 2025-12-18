{{-- resources/views/auth/forget-password.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="w-full h-auto bg-white flex items-start justify-center pt-10 pb-22">
    
    <div class="w-full max-w-[1800px] mx-auto px-4 lg:px-8 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">

        <div class="hidden lg:block lg:col-span-7">
            <div class="overflow-hidden relative shadow-sm">
                <img src="{{ asset('images/login/welcome.png') }}" 
                     class="w-full h-[550px] object-cover"
                     alt="Welcome Banner">
            </div>
        </div>

        <div class="w-full px-4 lg:px-12 lg:col-span-5">
            <h2 class="text-4xl font-extrabold mb-4 text-center bg-gradient-to-r from-[#0D47A1] to-[#42A5F5] bg-clip-text text-transparent pb-2">
                QUÊN MẬT KHẨU
            </h2>
            
            <p class="text-gray-700 mb-10 text-center text-sm px-4 leading-relaxed">
                Nhập email bạn đã đăng ký.<br>
                Chúng tôi sẽ gửi mã xác minh gồm 6 số để đặt lại mật khẩu.
            </p>

            @if(session('error'))
                <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-6 text-center text-sm border border-red-200">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-6 text-center text-sm border border-green-200">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('forget-password.send') }}" method="POST" class="space-y-8">
                @csrf
                
                <div class="group">
                    <label class="block text-gray-700 text-sm mb-1 font-semibold">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="w-full border-0 border-b border-gray-300 px-0 py-2 focus:ring-0 focus:border-[#1976D2] transition-colors bg-transparent text-gray-800 placeholder-gray-400"
                        placeholder="example@email.com" required>
                    @error('email')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-2 flex justify-center">
                    <button type="submit" class="bg-[#1976D2] hover:bg-blue-600 text-white py-3 px-8 w-56 rounded-full font-bold shadow-lg shadow-blue-500/30 transition transform hover:-translate-y-0.5 cursor-pointer uppercase tracking-wider text-sm">
                        Nhận mã ngay
                    </button>
                </div>

                <div class="text-center text-sm text-gray-600 mt-4">
                    Bạn đã nhớ mật khẩu? 
                    <a href="{{ route('login') }}" class="text-[#1976D2] hover:underline font-medium">Đăng nhập</a>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Đồng bộ CSS input autofill từ trang Login */
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