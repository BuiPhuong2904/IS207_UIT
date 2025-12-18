@extends('layouts.ad_layout')

@section('title', 'Quản lý lịch lớp')

@section('content')

{{-- CSRF TOKEN --}}
<meta name="csrf-token" content="{{ csrf_token() }}">

@if(session('success'))
    <div id="alert-success" class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
        <strong class="font-bold">Thành công!</strong>
        <span class="block sm:inline">{{ session('success') }}</span>
        <span class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="document.getElementById('alert-success').style.display='none'">
            <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
        </span>
    </div>
    
    {{-- Tự động ẩn sau 3 giây --}}
    <script>
        setTimeout(function() {
            const alert = document.getElementById('alert-success');
            if(alert) alert.style.display = 'none';
        }, 3000);
    </script>
@endif

@if($errors->any())
    <div id="alert-error" class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
        <strong class="font-bold">Lỗi!</strong>
        <ul class="list-disc pl-5 mt-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="bg-white rounded-2xl shadow-sm p-6">
    
    <div class="flex justify-between items-center mb-6">
        <h1 class="font-montserrat text-2xl text-black font-semibold">Lịch lớp</h1>
        
        <div class="flex items-center space-x-4 font-open-sans">
            
            <div class="flex items-center text-black cursor-pointer hover:text-gray-900">
                <span class="mr-1 text-sm font-medium">Hôm nay</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </div>

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
            
            <thead class="font-montserrat text-[#1f1d1d] text-sm text-center ">
                <tr>
                    <th class="py-4 px-4 w-[5%] truncate">ID</th>                  
                    <th class="py-4 px-4 w-[10%] truncate">Tên lớp</th> 
                    <th class="py-4 px-4 w-[10%] truncate">Ngày</th>                    
                    <th class="py-4 px-4 w-[10%] truncate">Thời gian</th>                    
                    <th class="py-4 px-4 w-[10%] truncate">Phòng</th>                    
                    <th class="py-4 px-4 w-[20%] truncate">Chi nhánh</th>                   
                    <th class="py-4 px-4 w-[10%] truncate">Danh sách</th>                   
                    <th class="py-4 px-4 w-[15%] truncate">Trạng thái</th>
                </tr>
            </thead>
           
            <tbody class="text-sm text-gray-700 text-center">
                @foreach($schedules as $item)
                    @php
                        $isOdd = $loop->odd;
                        $rowBg = $isOdd ? 'bg-[#1976D2]/20' : 'bg-white';
                        $roundLeft = $isOdd ? 'rounded-l-xl' : '';
                        $roundRight = $isOdd ? 'rounded-r-xl' : '';

                        $editData = [
                            'id' => $item->schedule_id, 
                            'formatted_id' => $item->formatted_id, // LL0001
                            'class_id' => $item->class_id,
                            'class_name' => $item->gymClass->class_name ?? 'N/A',
                            'date' => $item->date, // Y-m-d
                            'start_time' => \Carbon\Carbon::parse($item->start_time)->format('H:i'),
                            'end_time' => \Carbon\Carbon::parse($item->end_time)->format('H:i'),
                            'room' => $item->room,
                            'branch_id' => $item->branch_id,
                            'branch_name' => $item->branch->branch_name ?? 'N/A',
                            'trainer_id' => $item->trainer_id,
                            'trainer_name' => $item->trainer->user->full_name ?? 'N/A',
                            'status' => $item->status
                        ];
                    @endphp

                    {{-- Onclick gọi hàm mở modal sửa với dữ liệu thật --}}
                    <tr class="{{ $rowBg }} cursor-pointer transition-colors" onclick='openEditModal(@json($editData))'>
                        
                        <td class="py-4 px-4 truncate align-middle {{ $roundLeft }} font-medium">{{ $item->formatted_id }}</td>
                        
                        {{-- Tên lớp --}}
                        <td class="py-4 px-4 truncate align-middle font-medium">{{ $item->gymClass->class_name ?? 'N/A' }}</td>
                        
                        {{-- Ngày --}}
                        <td class="py-4 px-4 truncate align-middle">{{ \Carbon\Carbon::parse($item->date)->format('d/m/Y') }}</td>
                        
                        {{-- Thời gian --}}
                        <td class="py-4 px-4 truncate align-middle">
                            {{ \Carbon\Carbon::parse($item->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($item->end_time)->format('H:i') }}
                        </td>
                        
                        {{-- Phòng --}}
                        <td class="py-4 px-4 truncate align-middle">{{ $item->room }}</td>
                        
                        {{-- Chi nhánh --}}
                        <td class="py-4 px-4 truncate align-middle">{{ $item->branch->branch_name ?? 'N/A' }}</td>
                        
                        {{-- Nút xem danh sách --}}
                        <td class="py-4 px-4 truncate align-middle">
                            <button onclick="openViewModal('{{ $item->formatted_id }}', event)" class="bg-[#1976D2] hover:bg-blue-700 text-white text-xs px-4 py-1.5 rounded transition-colors">
                                Xem
                            </button>
                        </td>

                        {{-- Trạng thái --}}
                        <td class="py-4 px-4 truncate align-middle {{ $roundRight }}">
                            @switch($item->status)
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

        {{-- Pagination --}}
        <div class="mt-4 flex justify-center">
            {{ $schedules->links() }}
        </div>

    </div>
</div>

{{-- Include các Modal --}}
@include('admin.partials.add_class_schedule_modal')
@include('admin.partials.edit_class_schedule_modal')
@include('admin.partials.view_class_schedule_modal')

<script>
    // --- 1. ĐỊNH NGHĨA LOGIC CHUNG (ScheduleApp) ---
    const ScheduleApp = {
        // Toggle Modal
        toggleModal: function(modalID) {
            const modal = document.getElementById(modalID);
            if(modal) modal.classList.toggle('hidden');
        },

        // Toggle Dropdown
        toggleDropdown: function(targetId) {
            // Đóng các dropdown khác trước
            document.querySelectorAll('.dropdown-panel').forEach(panel => {
                if (panel.id !== targetId) panel.classList.add('hidden');
            });

            const panel = document.getElementById(targetId);
            if (panel) {
                panel.classList.toggle('hidden');
                if (!panel.classList.contains('hidden')) {
                    const searchInput = panel.querySelector('input[type="text"]');
                    if(searchInput) searchInput.focus();
                }
            }
        },

        // Hàm hiển thị dữ liệu lên Dropdown (QUAN TRỌNG NHẤT)
        selectItem: function(config) {
            // 1. Gán giá trị vào Input ẩn (để gửi lên server)
            const hiddenInput = document.getElementById(config.inputId);
            if(hiddenInput) hiddenInput.value = config.value;

            // 2. Hiển thị tên ra thẻ Span
            const displayEl = document.getElementById(config.displayId);
            if(displayEl) {
                // Nếu có tên thì hiển thị, nếu null/rỗng thì hiện "Chọn..."
                displayEl.innerText = (config.text && config.text !== 'N/A') ? config.text : displayEl.getAttribute('data-default') || config.text;
                
                // Đổi màu chữ
                if(config.value && config.text !== 'N/A') {
                    displayEl.classList.remove('text-gray-500');
                    displayEl.classList.add('text-[#333333]', 'font-semibold');
                } else {
                    displayEl.classList.add('text-gray-500');
                    displayEl.classList.remove('text-[#333333]', 'font-semibold');
                }
            }

            // 3. Đóng dropdown sau khi chọn
            if(config.dropdownId) {
                const dropdown = document.getElementById(config.dropdownId);
                if(dropdown) dropdown.classList.add('hidden');
            }
        },

        // Hàm tìm kiếm trong list
        filterList: function(inputId, listId) {
            const input = document.getElementById(inputId);
            const listContainer = document.getElementById(listId);
            if(!input || !listContainer) return;
            const filter = input.value.toLowerCase();
            const items = listContainer.getElementsByTagName('li');
            for (let i = 0; i < items.length; i++) {
                const txtValue = items[i].textContent || items[i].innerText;
                items[i].style.display = txtValue.toLowerCase().indexOf(filter) > -1 ? "" : "none";
            }
        }
    };

    // --- 2. SỰ KIỆN GLOBAL ---
    // Đóng dropdown khi click ra ngoài
    window.addEventListener('click', function(e) {
        if (!e.target.closest('.dropdown-container')) {
            document.querySelectorAll('.dropdown-panel').forEach(el => el.classList.add('hidden'));
        }
    });

    // Wrapper functions để gọi onclick trong HTML
    function toggleModal(id) { ScheduleApp.toggleModal(id); }
    function toggleDropdown(id) { ScheduleApp.toggleDropdown(id); }
    
    // Wrapper cho Add Modal
    function filterAddClasses() { ScheduleApp.filterList('add-class-search', 'add-class-list'); }
    function selectAddClass(id, name) { ScheduleApp.selectItem({inputId: 'selected_class_id', displayId: 'add-class-display-text', dropdownId: 'add-class-options', value: id, text: name}); }
    function filterBranches() { ScheduleApp.filterList('branch-search', 'branch-list'); }
    function selectBranch(id, name) { ScheduleApp.selectItem({inputId: 'selected_branch_id', displayId: 'branch-display-text', dropdownId: 'branch-options', value: id, text: name}); }
    function filterTrainers() { ScheduleApp.filterList('trainer-search', 'trainer-list'); }
    function selectTrainer(id, name) { ScheduleApp.selectItem({inputId: 'selected_trainer_id', displayId: 'trainer-display-text', dropdownId: 'trainer-options', value: id, text: name}); }

    // Wrapper cho Edit Modal
    function filterEditClasses() { ScheduleApp.filterList('edit-class-search', 'edit-class-list'); }
    function selectEditClass(id, name) { ScheduleApp.selectItem({inputId: 'edit_selected_class_id', displayId: 'edit-class-display-text', dropdownId: 'edit-class-options', value: id, text: name}); }
    function filterEditBranches() { ScheduleApp.filterList('edit-branch-search', 'edit-branch-list'); }
    function selectEditBranch(id, name) { ScheduleApp.selectItem({inputId: 'edit_selected_branch_id', displayId: 'edit-branch-display-text', dropdownId: 'edit-branch-options', value: id, text: name}); }
    function filterEditTrainers() { ScheduleApp.filterList('edit-trainer-search', 'edit-trainer-list'); }
    function selectEditTrainer(id, name) { ScheduleApp.selectItem({inputId: 'edit_selected_trainer_id', displayId: 'edit-trainer-display-text', dropdownId: 'edit-trainer-options', value: id, text: name}); }

    // --- 3. DỮ LIỆU & LOGIC CHÍNH ---
    const studentLists = @json($student_lists);

    // Hàm mở Modal Sửa 
    function openEditModal(data) {
        console.log("Edit Data:", data); // Debug 

        toggleModal('edit-modal');

        // 1. Cập nhật Form Action
        const form = document.querySelector('#edit-modal form');
        if(form) form.action = `/admin/class_schedule/${data.id}`; 

        // 2. Gán giá trị input thường
        if(document.getElementById('edit_id')) document.getElementById('edit_id').value = data.formatted_id;
        if(document.getElementById('edit_date')) document.getElementById('edit_date').value = data.date;
        if(document.getElementById('edit_start_time')) document.getElementById('edit_start_time').value = data.start_time;
        if(document.getElementById('edit_end_time')) document.getElementById('edit_end_time').value = data.end_time;
        if(document.getElementById('edit_room')) document.getElementById('edit_room').value = data.room;
        if(document.getElementById('edit_status')) document.getElementById('edit_status').value = data.status;

        // 3. Gán giá trị Dropdown Custom
        // Lớp học
        ScheduleApp.selectItem({
            inputId: 'edit_selected_class_id',
            displayId: 'edit-class-display-text',
            value: data.class_id,
            text: data.class_name
        });

        // Chi nhánh
        ScheduleApp.selectItem({
            inputId: 'edit_selected_branch_id',
            displayId: 'edit-branch-display-text',
            value: data.branch_id,
            text: data.branch_name
        });

        // HLV
        ScheduleApp.selectItem({
            inputId: 'edit_selected_trainer_id',
            displayId: 'edit-trainer-display-text',
            value: data.trainer_id,
            text: data.trainer_name
        });
    }

    // Hàm mở Modal Xem
    function openViewModal(scheduleId, event) {
        event.stopPropagation();
        toggleModal('view-modal');
        const list = studentLists[scheduleId] || [];
        const tbody = document.getElementById('student-list-body');
        tbody.innerHTML = '';

        if (list.length > 0) {
            list.forEach((student, index) => {
                const isOdd = (index % 2 === 0); 
                const rowBg = isOdd ? 'bg-[#1976D2]/20' : 'bg-white';
                const roundLeft = isOdd ? 'rounded-l-xl' : '';
                const roundRight = isOdd ? 'rounded-r-xl' : '';
                
                // let statusBadge = '';
                // switch (student.status) {
                //     case 'attended': statusBadge = `<span class="bg-[#28A745]/10 text-[#28A745]/70 py-1 px-3 rounded-full text-sm font-semibold">Đã tham gia</span>`; break;
                //     case 'registered': statusBadge = `<span class="bg-[#1976D2]/10 text-[#1976D2]/70 py-1 px-3 rounded-full text-sm font-semibold">Đã đăng ký</span>`; break;
                //     case 'cancelled': statusBadge = `<span class="bg-[#DC3545]/10 text-[#DC3545]/70 py-1 px-3 rounded-full text-sm font-semibold">Đã hủy</span>`; break;
                //     default: statusBadge = `<span class="bg-gray-200 text-gray-500 py-1 px-3 rounded-full text-xs font-bold">Không xác định</span>`;
                // }

                let actionHtml = '';

                if (student.status === 'cancelled') {
                    actionHtml = `<span class="bg-[#DC3545]/10 text-[#DC3545]/70 py-1 px-3 rounded-full text-sm font-semibold">Đã hủy</span>`;
                } else {
                    // Nếu là registered hoặc attended thì hiện nút Toggle
                    const isChecked = (student.status === 'attended') ? 'checked' : '';
                    
                    // Giao diện nút Toggle
                    actionHtml = `
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" value="" class="sr-only peer" 
                                onchange="handleCheckIn(${student.id}, this)" ${isChecked}>
                            
                            <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer 
                                peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full 
                                peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] 
                                after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full 
                                after:h-5 after:w-5 after:transition-all peer-checked:bg-green-500"></div>
                                
                            <span class="ms-5 ${isChecked ? 'bg-[#28A745]/10 text-[#28A745]/70' : 'bg-[#1976D2]/10 text-[#1976D2]/70'} py-1 px-3 rounded-full text-sm font-semibold">
                                ${isChecked ? 'Đã tham gia' : 'Đã đăng ký'}
                            </span>
                        </label>
                    `;
                }

                const row = `
                    <tr class="${rowBg}">
                        <td class="py-4 px-4 text-center align-middle ${roundLeft}">${student.name}</td>
                        <td class="py-4 px-4 text-center align-middle">${student.date}</td>
                        <td class="py-4 px-4 text-center align-middle ${roundRight}"> ${actionHtml} </td>
                    </tr>
                    <tr class="h-2"></tr>
                `;
                tbody.innerHTML += row;
            });
        } else {
            tbody.innerHTML = `<tr><td colspan="3" class="py-4 text-center text-gray-500">Chưa có học viên đăng ký</td></tr>`;
        }
    }

    // --- XỬ LÝ XÓA LỊCH ---
    document.addEventListener('DOMContentLoaded', function() {
        const deleteBtn = document.getElementById('btn-delete-class');
        
        if (deleteBtn) {
            deleteBtn.addEventListener('click', function() {
                // 1. Lấy ID lịch đang sửa (từ input hidden edit_id hoặc action của form)
                // Lưu ý: edit_id đang chứa formatted ID (LL0001), ta cần ID thật từ data gốc hoặc parse lại.
                // Cách an toàn nhất: Lấy ID từ action của form
                const form = document.querySelector('#edit-modal form');
                const actionUrl = form.getAttribute('action'); // /admin/class-schedule/1
                
                if (!actionUrl) return;

                if (!confirm('Bạn có chắc chắn muốn xóa lịch học này không?')) return;

                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                fetch(actionUrl, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        location.reload();
                    } else {
                        alert('Có lỗi xảy ra: ' + (data.message || 'Lỗi không xác định'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Lỗi kết nối server.');
                });
            });
        }
    });

    // --- HÀM XỬ LÝ GỌI API CHECK-IN ---
    function handleCheckIn(registrationId, checkbox) {
        console.log("Check-in ID:", registrationId); 

        if (!registrationId) {
            alert("Lỗi: Không lấy được ID học viên!");
            checkbox.checked = !checkbox.checked;
            return;
        }
        
        const spanLabel = checkbox.parentElement.querySelector('span');
        
        checkbox.disabled = true;
        
        fetch('{{ route("admin.class.checkin") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ registration_id: registrationId })
        })
        .then(response => response.json())
        .then(data => {
            checkbox.disabled = false;
            if (data.success) {
                if (data.new_status === 'attended') {
                    if(spanLabel) {
                        spanLabel.className = 'ms-5 bg-[#28A745]/10 text-[#28A745]/70 py-1 px-3 rounded-full text-sm font-semibold';
                        spanLabel.innerText = 'Đã tham gia';
                    }
                } else {
                    if(spanLabel) {
                        spanLabel.className = 'ms-5 bg-[#1976D2]/10 text-[#1976D2]/70 py-1 px-3 rounded-full text-sm font-semibold';
                        spanLabel.innerText = 'Đã đăng ký';
                    }
                }

                for (const schId in studentLists) {
                    const foundStudent = studentLists[schId].find(s => s.id === registrationId);
                    if (foundStudent) {
                        foundStudent.status = data.new_status;
                        break;
                    }
                }
            } else {
                alert(data.message);
                checkbox.checked = !checkbox.checked; 
            }
        })
        .catch(error => {
            checkbox.disabled = false;
            checkbox.checked = !checkbox.checked;
            console.error('Error:', error);
            alert('Lỗi kết nối server.');
        });
    }
</script>

@endsection