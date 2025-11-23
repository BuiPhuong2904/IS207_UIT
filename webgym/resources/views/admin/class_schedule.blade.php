@extends('layouts.ad_layout')

@section('title', 'Quản lý lịch lớp')

@section('content')

{{-- PHẦN DỮ LIỆU GIẢ (BACKEND CHỈ CẦN THAY BIẾN $schedules NÀY LÀ XONG) --}}
@php
    $schedules = [
        [
            'id' => 'LL0001',
            'class_code' => 'DS0001',
            'date' => '11/07/2025',
            'time' => '07:00 AM - 09:00 AM',
            'room' => 'B1.20',
            'branch' => 'Võ Thị Sáu',
            'status' => 'completed',
        ],
        [
            'id' => 'LL0002',
            'class_code' => 'DS0002',
            'date' => '11/09/2025',
            'time' => '07:00 AM - 09:00 AM',
            'room' => 'B1.22',
            'branch' => 'Võ Thị Sáu',
            'status' => 'scheduled',
        ],
        [
            'id' => 'LL0003',
            'class_code' => 'DS0003',
            'date' => '11/08/2025',
            'time' => '07:00 AM - 09:00 AM',
            'room' => 'B1.18',
            'branch' => 'Võ Thị Sáu',
            'status' => 'cancelled',
        ],
    ];

    // Dữ liệu giả cho Dropdown trong Modal
    $classes_list = [ ['id' => 1, 'name' => 'Lớp Piano Cơ Bản'], ['id' => 2, 'name' => 'Lớp Guitar'] ];
    $branches_list = [ ['id' => 1, 'name' => 'Võ Thị Sáu'], ['id' => 2, 'name' => 'Lê Văn Sỹ'], ['id' => 3, 'name' => 'Lê Văn A'] ];
    $rooms_list = [ ['id' => 1, 'name' => 'B1.20'], ['id' => 2, 'name' => 'B1.22'] ];

    // 2. DỮ LIỆU GIẢ CHO MODAL "XEM DANH SÁCH"
    $student_lists = [
        'LL0001' => [ // Danh sách của lớp 1
            ['name' => 'Sơn Tùng MTP', 'date' => '12/11/2025', 'status' => 'attended'],
            ['name' => 'Trấn Thành', 'date' => '12/11/2025', 'status' => 'cancelled'],
            ['name' => 'Anh Tú', 'date' => '12/11/2025', 'status' => 'cancelled'],
            ['name' => 'Liên Bỉnh Phát', 'date' => '12/11/2025', 'status' => 'attended'],
            ['name' => 'Lan Ngọc', 'date' => '12/11/2025', 'status' => 'registered'],
        ],
        'LL0002' => [ // Danh sách của lớp 2
            ['name' => 'HIEUTHUHAI', 'date' => '13/11/2025', 'status' => 'attended'],
            ['name' => 'Trường Giang', 'date' => '13/11/2025', 'status' => 'registered'],
        ],
        'LL0003' => [ // Danh sách của lớp 3 
            ['name' => 'Mỹ Tâm', 'date' => '14/11/2025', 'status' => 'attended'],
            ['name' => 'Đức Phúc', 'date' => '14/11/2025', 'status' => 'attended'],
            ['name' => 'Noo Phước Thịnh', 'date' => '14/11/2025', 'status' => 'cancelled'],
        ]
    ];
@endphp


<div class="bg-white rounded-2xl shadow-sm p-6">
    
    <div class="flex justify-between items-center mb-6">
        <h1 class="font-montserrat text-2xl text-black font-semibold">Lịch lớp</h1>
        
        <div class="flex items-center space-x-4 font-open-sans">
            
            <!-- Dropdown Hôm nay -->
            <div class="flex items-center text-black cursor-pointer hover:text-gray-900">
                <span class="mr-1 text-sm font-medium">Hôm nay</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </div>

            <!-- Nút Thêm -->
            <button onclick="toggleModal('add-modal')" class="bg-[#28A745] hover:bg-[#218838] text-white px-4 py-2 rounded-full flex items-center text-sm font-semibold transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Thêm
            </button>

        </div>
    </div>

    <div class="overflow-x-auto">
        
        <table class="w-full text-left border-collapse table-auto font-open-sans">
            
            <!-- Table Header -->
            <thead class="text-gray-400 font-normal text-sm text-center">
                <tr>
                    <th class="py-4 px-4 w-[5%] truncate">ID</th>                  
                    <th class="py-4 px-4 w-[10%] truncate">Mã lớp</th>                    
                    <th class="py-4 px-4 w-[10%] truncate">Ngày</th>                    
                    <th class="py-4 px-4 w-[10%] truncate">Thời gian</th>                    
                    <th class="py-4 px-4 w-[10%] truncate">Phòng</th>                    
                    <th class="py-4 px-4 w-[20%] truncate">Chi nhánh</th>                   
                    <th class="py-4 px-4 w-[10%] truncate">Danh sách</th>                   
                    <th class="py-4 px-4 w-[15%] truncate">Trạng thái</th>
                </tr>
            </thead>
           
            <!-- Table Body -->
            <tbody class="text-sm text-gray-700 text-center">
                @foreach($schedules as $item)
                    @php
                        $isOdd = $loop->odd;
                        $rowBg = $isOdd ? 'bg-[#1976D2]/20' : 'bg-white';
                        $roundLeft = $isOdd ? 'rounded-l-xl' : '';
                        $roundRight = $isOdd ? 'rounded-r-xl' : '';
                    @endphp

                    {{-- 
                        SỰ KIỆN ONCLICK ĐỂ MỞ MODAL SỬA:
                        - onclick='openEditModal(@json($item))'
                        - cursor-pointer: hiện bàn tay
                    --}}
                    <tr class="{{ $rowBg }} cursor-pointer transition-colors" onclick='openEditModal(@json($item))'>
                        <td class="py-4 px-4 truncate align-middle {{ $roundLeft }}">{{ $item['id'] }}</td>
                        <td class="py-4 px-4 truncate align-middle">{{ $item['class_code'] }}</td>
                        <td class="py-4 px-4 truncate align-middle">{{ $item['date'] }}</td>
                        <td class="py-4 px-4 truncate align-middle">{{ $item['time'] }}</td>
                        <td class="py-4 px-4 truncate align-middle">{{ $item['room'] }}</td>
                        <td class="py-4 px-4 truncate align-middle">{{ $item['branch'] }}</td>
                        <td class="py-4 px-4 truncate align-middle">
                            {{-- stopPropagation để ấn nút Xem không bị bật modal Sửa --}}
                            {{-- 
                                NÚT XEM DANH SÁCH 
                                - onclick: openViewModal(ID lớp, event)
                                - event: Để chặn click xuyên qua dòng (stopPropagation)
                            --}}
                            <button onclick="openViewModal('{{ $item['id'] }}', event)" class="bg-[#1976D2] hover:bg-blue-700 text-white text-xs px-4 py-1.5 rounded transition-colors">
                                Xem
                            </button>
                        </td>
                        <td class="py-4 px-4 truncate align-middle {{ $roundRight }}">
                            @switch($item['status'])
                                @case('completed') <span class="bg-[#28A745]/10 text-[#28A745]/70 py-1 px-3 rounded-full text-sm font-semibold">Đã hoàn thành</span> @break
                                @case('scheduled') <span class="bg-[#FFC107]/10 text-[#FFC107]/70 py-1 px-3 rounded-full text-sm font-semibold">Đã lên lịch</span> @break
                                @case('cancelled') <span class="bg-[#DC3545]/10 text-[#DC3545]/70 py-1 px-3 rounded-full text-sm font-semibold">Đã hủy</span> @break
                                @default <span class="bg-gray-100 text-gray-500 py-1 px-3 rounded-full text-sm font-semibold">Chưa xác định</span>
                            @endswitch
                        </td>
                    </tr>
                    <tr class="h-2"></tr>
                @endforeach
            </tbody>
            
        </table>

    </div>
</div>

{{-- GỌI FILE MODAL TỪ THƯ MỤC PARTIALS --}}
@include('admin.partials.add_class_schedule_modal')

{{-- Nhúng Modal Sửa (Mới) --}}
@include('admin.partials.edit_class_schedule_modal')

{{-- Nhúng Modal Xem Danh Sách (Mới) --}}
@include('admin.partials.view_class_schedule_modal')

<script>
    const studentLists = @json($student_lists);
    // --- 1. Hàm Toggle Modal chung (Giữ nguyên) ---
    function toggleModal(modalID) {
        const modal = document.getElementById(modalID);
        if(modal) {
            modal.classList.toggle('hidden');
        }
    }

 

</script>

@endsection