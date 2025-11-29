@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto mt-12 p-6 bg-white rounded shadow">
  <h2 class="text-2xl font-bold mb-4">Đặt lại mật khẩu</h2>

  @if ($errors->any())
    <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
      <ul class="list-disc pl-5">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ route('password.update') }}">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <label class="block mb-2">Email</label>
    <input name="email" type="email" value="{{ old('email', $email ?? '') }}" required class="w-full p-2 border rounded mb-4">

    <label class="block mb-2">Mật khẩu mới</label>
    <input name="password" type="password" required class="w-full p-2 border rounded mb-4">

    <label class="block mb-2">Xác nhận mật khẩu</label>
    <input name="password_confirmation" type="password" required class="w-full p-2 border rounded mb-4">

    <button type="submit" class="w-full bg-gradient-to-r from-[#3484d4] to-[#42A5F5] text-white py-3 rounded-full font-semibold shadow-md transition">
      ĐẶT LẠI MẬT KHẨU
    </button>
  </form>
</div>
@endsection
