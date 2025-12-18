{{-- resources/views/auth/register.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="w-full min-h-screen bg-white flex items-center justify-center py-6">
    
    <div class="w-full max-w-[1800px] mx-auto px-4 lg:px-8 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">

        <div class="hidden lg:block lg:col-span-7">
            <div class="overflow-hidden relative shadow-sm">
                <img src="{{ asset('images/login/welcome.png') }}" 
                     class="w-full h-[650px] object-cover"
                     alt="Welcome Banner">
            </div>
        </div>

        <div class="w-full px-4 lg:px-12 lg:col-span-5">
            <h2 class="text-4xl font-extrabold mb-8 text-center bg-gradient-to-r from-[#0D47A1] to-[#42A5F5] bg-clip-text text-transparent pb-2">Đăng ký</h2>

            <div class="flex gap-4 mb-8 justify-center">
                <a href="{{ route('auth.google') }}" class="px-5 py-2 rounded-full border border-gray-200 bg-gray-50 flex items-center justify-center gap-2 hover:bg-white hover:shadow-md transition text-sm text-gray-600">
                    <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-5 h-5">
                    <span>Sign up with Google</span>
                </a>
                <a href="#" class="px-5 py-2 rounded-full border border-gray-200 bg-gray-50 flex items-center justify-center gap-2 hover:bg-white hover:shadow-md transition text-sm text-gray-600">
                    <img src="https://www.svgrepo.com/show/475647/facebook-color.svg" class="w-5 h-5" alt="Facebook Logo">
                    <span>Sign up with Facebook</span>
                </a>
            </div>

            @if ($errors->any())
                <div class="bg-red-50 text-red-600 px-4 py-3 rounded-lg mb-6 text-sm border border-red-100">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register.post') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div class="group">
                    <label class="block text-gray-500 text-sm mb-1">Tên người dùng</label>
                    <input type="text" name="full_name" value="{{ old('full_name') }}"
                        class="w-full border-0 border-b border-gray-300 px-0 py-2 focus:ring-0 focus:border-[#1976D2] transition-colors bg-transparent text-gray-800 placeholder-gray-400"
                        placeholder="Nguyễn Văn A" required>
                </div>

                <div class="group">
                    <label class="block text-gray-500 text-sm mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="w-full border-0 border-b border-gray-300 px-0 py-2 focus:ring-0 focus:border-[#1976D2] transition-colors bg-transparent text-gray-800 placeholder-gray-400"
                        placeholder="example@email.com" required>
                </div>

                <div class="group">
                    <label class="block text-gray-500 text-sm mb-1">Mật khẩu</label>
                    <div class="relative">
                        <input id="password" type="password" name="password"
                            class="w-full border-0 border-b border-gray-300 px-0 py-2 focus:ring-0 focus:border-[#1976D2] transition-colors bg-transparent text-gray-800 placeholder-gray-400"
                            placeholder="********" required>
                        <button type="button" id="togglePassword" class="absolute right-0 bottom-2 text-gray-400 hover:text-[#1976D2] transition">
                            
                        </button>
                    </div>
                </div>

                <div class="group">
                    <label class="block text-gray-500 text-sm mb-1">Xác nhận mật khẩu</label>
                    <input type="password" name="password_confirmation"
                        class="w-full border-0 border-b border-gray-300 px-0 py-2 focus:ring-0 focus:border-[#1976D2] transition-colors bg-transparent text-gray-800 placeholder-gray-400"
                        placeholder="********" required>
                </div>

                <div class="pt-4 flex justify-center">
                    <button type="submit"
                        class="bg-[#1976D2] hover:bg-blue-600 text-white py-3 px-12 rounded-full font-bold shadow-lg shadow-blue-500/30 transition transform hover:-translate-y-0.5 cursor-pointer uppercase tracking-wider text-sm w-full md:w-auto">
                        Đăng ký
                    </button>
                </div>

                <div class="text-center text-sm text-gray-600 mt-4">
                    Đã có tài khoản? 
                    <a href="{{ route('login') }}" class="text-[#1976D2] hover:underline font-medium">Đăng nhập</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('togglePassword')?.addEventListener('click', function () {
        const input = document.getElementById('password');
        const isPass = input.type === 'password';
        input.type = isPass ? 'text' : 'password';
        this.textContent = isPass ? 'Ẩn' : 'Hiện';
    });
</script>

<style>
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