@extends('user.layouts.user_dashboard')

@section('title', 'Lịch sử mượn trả - GRYND')

@section('content')

{{-- HEADER --}}
<div class="mb-8">
    <h1 class="text-2xl font-bold text-black font-montserrat">Lịch sử mượn trả của bạn</h1>
    <p class="text-sm text-gray-500 mt-1 font-open-sans">Quản lý các vật dụng, thiết bị đã thuê tại phòng tập</p>
</div>

{{-- TABS TRẠNG THÁI --}}
<div class="bg-white rounded-2xl shadow-sm p-2 border border-gray-100 mb-6 font-open-sans">
    <div class="flex w-full text-sm font-semibold text-center text-gray-500">
        @foreach ($tabs as $key => $label)
            <a href="{{ route('rental_history', ['status' => $key]) }}" 
               class="flex-1 py-2.5 rounded-xl transition-all duration-200
               {{ $status == $key ? 'bg-blue-100 text-blue-700 shadow-sm' : 'hover:bg-gray-50' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>
</div>

{{-- DANH SÁCH GIAO DỊCH --}}
<div class="font-open-sans space-y-4">
    @if($transactions->count() > 0)
        @foreach ($transactions as $trans)
            @php
                // Tính tổng tiền = Số lượng * Phí thuê
                $itemPrice = $trans->item->rental_fee ?? 0;
                $totalPrice = $itemPrice * $trans->quantity;
                
                // Format mã giao dịch
                $code = 'RT' . str_pad($trans->transaction_id, 4, '0', STR_PAD_LEFT);
                
                // Hình ảnh
                $image = $trans->item->image_url ?? asset('images/no-image.png');
            @endphp

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                
                {{-- Card Header: Mã GD & Ngày mượn --}}
                <div class="px-6 py-3 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <span class="font-bold text-gray-800 text-sm">
                        Mã giao dịch: <span class="font-mono">#{{ $code }}</span>
                    </span>
                    <span class="text-xs text-gray-600 font-semibold">
                        Ngày mượn: {{ \Carbon\Carbon::parse($trans->borrow_date)->format('d/m/Y') }}
                    </span>
                </div>

                {{-- Card Body: Thông tin vật phẩm --}}
                <div class="p-6">
                    <div class="flex gap-4">
                        {{-- Ảnh vật phẩm --}}
                        <div class="w-20 h-20 shrink-0 border border-gray-200 rounded-lg overflow-hidden bg-gray-100">
                            <img src="{{ $image }}" alt="{{ $trans->item->item_name ?? 'Item' }}" class="w-full h-full object-cover">
                        </div>

                        {{-- Thông tin chi tiết --}}
                        <div class="flex-1 flex flex-col justify-between">
                            <div>
                                <div class="flex justify-between items-start">
                                    <h3 class="font-bold text-gray-800 text-base line-clamp-1">
                                        {{ $trans->item->item_name ?? 'Vật phẩm đã xóa' }}
                                    </h3>
                                    <span class="font-bold text-gray-800">
                                        {{ number_format($itemPrice, 0, ',', '.') }} VNĐ
                                    </span>
                                </div>
                                
                                <p class="text-sm text-gray-500 mt-1">
                                    Số lượng: <span class="font-semibold text-gray-700">x{{ $trans->quantity }}</span>
                                </p>
                                
                                <p class="text-sm text-gray-500 mt-0.5">
                                    Chi nhánh: {{ $trans->item->branch->branch_name ?? 'Toàn hệ thống' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card Footer: Trạng thái & Tổng tiền --}}
                <div class="px-6 py-4 border-t border-dashed border-gray-200 flex justify-between items-center">
                    <div class="text-sm">
                        Trạng thái: 
                        @if ($trans->status == 'renting')
                            <span class="text-yellow-500 font-bold ml-1">Đang mượn</span>
                        @else
                            <span class="text-green-600 font-bold ml-1">Đã trả</span>
                            @if($trans->return_date)
                                <span class="block text-gray-600 text-sm mt-1">Ngày trả: {{ \Carbon\Carbon::parse($trans->return_date)->format('d/m/Y') }}</span>
                            @endif
                        @endif
                    </div>

                    <div class="flex items-center gap-2">
                        <span class="text-sm text-gray-600">Tổng tiền:</span>
                        <span class="text-xl font-bold text-red-600">
                            {{ number_format($totalPrice, 0, ',', '.') }} VNĐ
                        </span>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        {{-- EMPTY STATE --}}
        <div class="bg-white rounded-2xl shadow-sm p-12 border border-gray-100 text-center">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-800">Chưa có giao dịch nào</h3>
            <p class="text-gray-500 mt-1">Bạn chưa thực hiện mượn trả đồ nào trong trạng thái này.</p>
        </div>
    @endif
</div>

@endsection