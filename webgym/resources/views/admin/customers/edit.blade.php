@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-12 px-6">
    <h2 class="text-3xl font-bold text-[#0D47A1] mb-6">Chỉnh sửa khách hàng</h2>

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
        <form action="{{ route('admin.customers.update', $customer->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Họ và tên</label>
                    <input type="text" name="full_name" value="{{ old('full_name', $customer->full_name) }}" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-[#1976D2] outline-none" required>
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email', $customer->email) }}" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-[#1976D2] outline-none" required>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Số điện thoại</label>
                    <input type="tel" name="phone" value="{{ old('phone', $customer->phone) }}" placeholder="0123 456 789" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-[#1976D2] outline-none">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Ngày sinh</label>
                    <input type="date" name="birth_date" value="{{ old('birth_date', $customer->birth_date) }}" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-[#1976D2] outline-none">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Giới tính</label>
                    <select name="gender" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-[#1976D2] outline-none">
                        <option value="">Chọn giới tính</option>
                        <option value="Nam" {{ old('gender', $customer->gender) === 'Nam' ? 'selected' : '' }}>Nam</option>
                        <option value="Nữ" {{ old('gender', $customer->gender) === 'Nữ' ? 'selected' : '' }}>Nữ</option>
                        <option value="Khác" {{ old('gender', $customer->gender) === 'Khác' ? 'selected' : '' }}>Khác</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Địa chỉ</label>
                    <input type="text" name="address" value="{{ old('address', $customer->address) }}" placeholder="123 Đường Nguyễn Văn Tấn" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-[#1976D2] outline-none">
                </div>
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-1">Ảnh đại diện</label>
                <input type="file" name="image" class="w-full border rounded px-3 py-2 bg-white">
                @if($customer->image_url)
                    <p class="text-sm text-gray-600 mt-2">Ảnh hiện tại: </p>
                    <img src="{{ $customer->image_url }}" class="w-20 h-20 rounded mt-2">
                @endif
            </div>

            <div class="flex justify-between">
                <a href="{{ url('/admin/customers') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded font-semibold">Hủy</a>
                <button type="submit" class="bg-[#1976D2] hover:bg-blue-700 text-white px-6 py-2 rounded font-semibold">Cập nhật</button>
            </div>
        </form>
    </div>
</div>
@endsection
