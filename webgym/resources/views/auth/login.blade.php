{{-- resources/views/auth/login.blade.php --}}
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

        <!-- RIGHT LOGIN FORM -->
        <div class="w-full px-6 lg:px-10">
            <h2 class="text-3xl font-bold text-[#0D47A1] mb-6">Đăng nhập</h2>

            <!-- SOCIAL LOGIN -->
            <div class="flex gap-3 mb-5">
                <a href="{{ route('auth.google') }}" class="flex-1 border border-gray-300 py-2 rounded-lg flex items-center justify-center gap-2 hover:bg-gray-50 text-gray-700">
                    <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-5 h-5">
                    <span>Sign up with Google</span>
                </a>
                <a href="#" class="flex-1 border border-gray-300 py-2 rounded-lg flex items-center justify-center gap-2 hover:bg-gray-50 text-gray-700">
                    <img src="https://www.svgrepo.com/show/512317/github-142.svg" class="w-5 h-5">
                    <span>Sign up with Github</span>
                </a>
            </div>

            <div class="text-center text-gray-500 text-sm mb-4">hoặc dùng email để đăng nhập</div>

            @if(session('error'))
                <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4 text-sm">{{ session('error') }}</div>
            @endif

            <form action="{{ route('login.post') ?? '#' }}" method="POST" class="space-y-4">
                @csrf

                <input type="hidden" name="return_url" value="{{ request('return_url') }}">
                
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-[#1976D2] focus:outline-none"
                        placeholder="johndoe@email.com" required>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Password</label>
                    <div class="relative">
                        <input id="password" type="password" name="password"
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-[#1976D2] focus:outline-none"
                            placeholder="********" required>
                        <button type="button" id="togglePassword" class="absolute right-3 top-1/2 -translate-y-1/2 text-sm text-gray-500">👁️</button>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <input type="checkbox" id="remember" name="remember" class="h-4 w-4">
                        <label for="remember" class="text-sm text-gray-600">Ghi nhớ tôi</label>
                    </div>
                    <a href="{{ route('forget-password') }}" class="text-sm text-[#1976D2] hover:underline">Quên mật khẩu?</a>
                </div>

                <button type="submit" class="w-full bg-[#1976D2] hover:bg-blue-700 text-white py-3 rounded-full font-semibold shadow-md transition cursor-pointer">ĐĂNG NHẬP</button>

                <div class="text-center text-sm text-gray-600">
                    Chưa có tài khoản? 
                    <a href="{{ route('register') }}" class="text-[#1976D2] hover:underline font-medium">Đăng ký</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JS: Toggle password -->
<script>
document.getElementById('togglePassword')?.addEventListener('click', function () {
    const input = document.getElementById('password');
    const isPass = input.type === 'password';
    input.type = isPass ? 'text' : 'password';
    this.textContent = isPass ? 'Ẩn' : 'Hiện';
});
</script>

@endsection
