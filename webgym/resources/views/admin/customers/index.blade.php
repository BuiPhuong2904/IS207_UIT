@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-12 px-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-[#0D47A1]">Quản lý khách hàng</h2>
        <a href="{{ route('admin.customers.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded font-semibold">+ Thêm khách hàng</a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-[#0D47A1] text-white">
                <tr>
                    <th class="px-6 py-3 text-left">ID</th>
                    <th class="px-6 py-3 text-left">Họ và tên</th>
                    <th class="px-6 py-3 text-left">Email</th>
                    <th class="px-6 py-3 text-left">Số điện thoại</th>
                    <th class="px-6 py-3 text-left">Ngày sinh</th>
                    <th class="px-6 py-3 text-left">Địa chỉ</th>
                    <th class="px-6 py-3 text-center">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $customer)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-6 py-3">{{ $customer->id }}</td>
                    <td class="px-6 py-3 font-medium">{{ $customer->full_name }}</td>
                    <td class="px-6 py-3">{{ $customer->email }}</td>
                    <td class="px-6 py-3">{{ $customer->phone ?? 'N/A' }}</td>
                    <td class="px-6 py-3">{{ $customer->birth_date ?? 'N/A' }}</td>
                    <td class="px-6 py-3">{{ $customer->address ?? 'N/A' }}</td>
                    <td class="px-6 py-3 text-center space-x-2">
                        <a href="{{ route('admin.customers.show', $customer->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm inline-block">Xem</a>
                        <a href="{{ route('admin.customers.edit', $customer->id) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white px-3 py-1 rounded text-sm inline-block">Sửa</a>
                        <form action="{{ route('admin.customers.destroy', $customer->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Bạn chắc chắn muốn xóa?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">Xóa</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-gray-500 py-6">Không có khách hàng nào.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
