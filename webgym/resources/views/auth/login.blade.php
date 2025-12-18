{{-- resources/views/auth/login.blade.php --}}
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
            <h2 class="text-4xl font-extrabold mb-10 text-center bg-gradient-to-r from-[#0D47A1] to-[#42A5F5] bg-clip-text text-transparent pb-2">ĐĂNG NHẬP</h2>

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

            @if(session('error'))
                <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-6 text-center text-sm">{{ session('error') }}</div>
            @endif

            <form action="{{ route('login.post') ?? '#' }}" method="POST" class="space-y-8">
                @csrf
                <input type="hidden" name="return_url" value="{{ request('return_url') }}">
                
                <div class="group">
                    <label class="block text-gray-700 text-sm mb-1 font-semibold">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="w-full border-0 border-b border-gray-300 px-0 py-2 focus:ring-0 focus:border-[#1976D2] transition-colors bg-transparent text-gray-800 placeholder-gray-400"
                        placeholder="example@email.com" required>
                </div>

                <div class="group">
                    <label class="block text-gray-700 text-sm mb-1 font-semibold">Mật khẩu</label>
                    <div class="relative">
                        <input id="password" type="password" name="password"
                            class="w-full border-0 border-b border-gray-300 px-0 py-2 focus:ring-0 focus:border-[#1976D2] transition-colors bg-transparent text-gray-800 placeholder-gray-400"
                            placeholder="*******" required>
                        
                        <button type="button" id="togglePassword" class="absolute right-0 bottom-2 text-gray-400 hover:text-[#1976D2] transition">
                            
                        </button>
                    </div>
                    
                    <div class="flex justify-end mt-2">
                        <a href="{{ route('forget-password') }}" class="text-sm text-gray-400 hover:text-[#1976D2] transition font-medium">
                            Quên mật khẩu?
                        </a>
                    </div>
                </div>

                <div class="pt-2 flex justify-center">
                    <button type="submit" class="bg-[#1976D2] hover:bg-blue-600 text-white py-3 px-10 w-48 rounded-full font-bold shadow-lg shadow-blue-500/30 transition transform hover:-translate-y-0.5 cursor-pointer uppercase tracking-wider text-sm">
                        Đăng nhập
                    </button>
                </div>

                <div class="text-center text-sm text-gray-600 mt-4">
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
