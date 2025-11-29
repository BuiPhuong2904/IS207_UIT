@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-12 px-6">
    <h2 class="text-3xl font-bold text-[#0D47A1] mb-6">Thêm khách hàng mới</h2>

    @if($errors->any())
        <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow p-8">
        <form action="{{ route('admin.customers.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Họ và tên <span class="text-red-600">*</span></label>
                    <input type="text" name="full_name" value="{{ old('full_name') }}" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-[#1976D2] outline-none" required>
                    @error('full_name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Email <span class="text-red-600">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-[#1976D2] outline-none" required>
                    @error('email')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Mật khẩu <span class="text-red-600">*</span></label>
                    <input type="password" name="password" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-[#1976D2] outline-none" required>
                    @error('password')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Xác nhận mật khẩu <span class="text-red-600">*</span></label>
                    <input type="password" name="password_confirmation" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-[#1976D2] outline-none" required>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Số điện thoại</label>
                    <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="0123 456 789" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-[#1976D2] outline-none">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Ngày sinh</label>
                    <input type="date" name="birth_date" value="{{ old('birth_date') }}" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-[#1976D2] outline-none">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Giới tính</label>
                    <select name="gender" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-[#1976D2] outline-none">
                        <option value="">Chọn giới tính</option>
                        <option value="Nam">Nam</option>
                        <option value="Nữ">Nữ</option>
                        <option value="Khác">Khác</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Địa chỉ</label>
                    <input type="text" name="address" value="{{ old('address') }}" placeholder="123 Đường Nguyễn Văn Tấn" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-[#1976D2] outline-none">
                </div>
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-1">Ảnh đại diện</label>
                <input type="file" name="image" class="w-full border rounded px-3 py-2 bg-white">
            </div>

            <div class="flex justify-between">
                <a href="{{ url('/admin/customers') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded font-semibold">Hủy</a>
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded font-semibold">Tạo khách hàng</button>
            </div>
        </form>
    </div>
</div>
@endsection
