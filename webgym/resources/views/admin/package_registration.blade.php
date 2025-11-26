@extends('layouts.ad_layout')

@section('title', 'Quản lý đăng ký gói tập')

@section('content')

{{-- CSRF TOKEN --}}
<meta name="csrf-token" content="{{ csrf_token() }}">

@php
    // 1. KHAI BÁO DỮ LIỆU GIẢ CHO DROPDOWN (Cần thêm phần này)
    
    // Giả lập danh sách GÓI TẬP (để sửa lỗi Undefined variable $packages)
    if (!isset($packages)) {
        $packages = collect([
            (object)['id' => 1, 'package_name' => 'Gói 1 Tháng', 'price' => 500000, 'duration' => 30],
            (object)['id' => 2, 'package_name' => 'Gói 3 Tháng', 'price' => 1200000, 'duration' => 90],
            (object)['id' => 3, 'package_name' => 'Gói PT Cá Nhân', 'price' => 5000000, 'duration' => 30],
            (object)['id' => 4, 'package_name' => 'Gói 6 Tháng', 'price' => 2000000, 'duration' => 180],
            (object)['id' => 5, 'package_name' => 'Gói Cực Tạ', 'price' => 9000000, 'duration' => 365],
        ]);
    }

    // Giả lập danh sách KHÁCH HÀNG (để sửa lỗi cho dropdown Khách hàng)
    if (!isset($users)) {
        $users = collect([
            (object)['id' => 101, 'full_name' => 'Nguyễn Văn A'],
            (object)['id' => 102, 'full_name' => 'Trần Thị B'],
            (object)['id' => 103, 'full_name' => 'Lê Văn C'],
            (object)['id' => 104, 'full_name' => 'Phạm Thị D'],
            (object)['id' => 105, 'full_name' => 'Hoàng Văn E'],
            (object)['id' => 106, 'full_name' => 'Sơn Tùng MTP'],
        ]);
    }

    // 2. KHAI BÁO DỮ LIỆU GIẢ CHO DANH SÁCH ĐĂNG KÝ
    $fakeRawData = [
        (object)[
            'id' => 1,
            'user_id' => 101,
            'user' => (object)['full_name' => 'Nguyễn Văn A'],
            'package_id' => 1,
            'package' => (object)['package_name' => 'Gói 1 Tháng'],
            'start_date' => '2025-11-26 00:00:00',
            'end_date' => '2025-12-26 00:00:00',
            'status' => 'active' 
        ],
        (object)[
            'id' => 2,
            'user_id' => 102,
            'user' => (object)['full_name' => 'Trần Thị B'],
            'package_id' => 2,
            'package' => (object)['package_name' => 'Gói 3 Tháng'],
            'start_date' => '2025-10-26 00:00:00',
            'end_date' => '2026-01-26 00:00:00',
            'status' => 'completed' 
        ],
        (object)[
            'id' => 3,
            'user_id' => 103,
            'user' => (object)['full_name' => 'Lê Văn C'],
            'package_id' => 3,
            'package' => (object)['package_name' => 'Gói PT Cá Nhân'],
            'start_date' => '2025-09-01 00:00:00',
            'end_date' => '2025-10-01 00:00:00',
            'status' => 'completed' 
        ],
        (object)[
            'id' => 4,
            'user_id' => 104,
            'user' => (object)['full_name' => 'Phạm Thị D'],
            'package_id' => 1,
            'package' => (object)['package_name' => 'Gói 1 Tháng'],
            'start_date' => '2025-11-01 00:00:00',
            'end_date' => '2025-12-01 00:00:00',
            'status' => 'completed'
        ],
        (object)[
            'id' => 5,
            'user_id' => 105,
            'user' => (object)['full_name' => 'Hoàng Văn E'],
            'package_id' => 2,
            'package' => (object)['package_name' => 'Gói 6 Tháng'],
            'start_date' => '2024-01-01 00:00:00',
            'end_date' => '2024-07-01 00:00:00',
            'status' => 'expired' 
        ],
        (object)[
            'id' => 6,
            'user_id' => 106,
            'user' => (object)['full_name' => 'Đặng Thị F'],
            'package_id' => 1,
            'package' => (object)['package_name' => 'Gói 1 Tháng'],
            'start_date' => '2025-11-28 00:00:00',
            'end_date' => '2025-12-28 00:00:00',
            'status' => 'active'
        ],
    ];

    // 3. Giả lập Paginator của Laravel
    if (!isset($registrations)) {
        $perPage = 10;
        $currentPage = Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPage();
        $collection = collect($fakeRawData);
        $currentPageItems = $collection->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $registrations = new Illuminate\Pagination\LengthAwarePaginator($currentPageItems, count($collection), $perPage);
        $registrations->setPath(request()->url());
    }
@endphp


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
    
    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="font-montserrat text-2xl text-black font-semibold">Đăng ký gói tập</h1>
        
        <div class="flex items-center space-x-4 font-open-sans">
            {{-- Filter Hôm nay --}}
            <div class="flex items-center text-black cursor-pointer hover:text-gray-900">
                <span class="mr-1 text-sm font-medium">Hôm nay</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </div>

            {{-- Nút Thêm --}}
            <button onclick="toggleModal('add-package-modal')" class="bg-[#28A745] hover:bg-[#218838] text-white px-4 py-2 rounded-full flex items-center text-sm font-semibold transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Thêm
            </button>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse table-auto font-open-sans">
            
            {{-- Table Header --}}
            <thead class="font-montserrat text-[#1f1d1d] text-sm text-center">
                <tr>
                    <th class="py-4 px-4 w-[10%] truncate">ID</th>                  
                    <th class="py-4 px-4 w-[25%] truncate">Khách hàng</th> 
                    <th class="py-4 px-4 w-[20%] truncate">Gói tập</th>                    
                    <th class="py-4 px-4 w-[15%] truncate">Ngày bắt đầu</th>                    
                    <th class="py-4 px-4 w-[15%] truncate">Ngày kết thúc</th>                    
                    <th class="py-4 px-4 w-[15%] truncate">Trạng thái</th>
                </tr>
            </thead>
           
            {{-- Table Body --}}
            <tbody class="text-sm text-gray-700 text-center">
                @foreach($registrations as $item)
                    @php
                        $formattedId = 'DK' . str_pad($item->id, 4, '0', STR_PAD_LEFT);

                        $isOdd = $loop->odd;
                        $rowBg = $isOdd ? 'bg-[#1976D2]/20' : 'bg-white'; 
                        $roundLeft = $isOdd ? 'rounded-l-xl' : '';
                        $roundRight = $isOdd ? 'rounded-r-xl' : '';

                        // Chuẩn bị dữ liệu để sửa
                        $editData = [
                            'id' => $item->id,
                            'formatted_id' => $formattedId,
                            'user_id' => $item->user_id,
                            'user_name' => $item->user->full_name ?? 'Khách lẻ',
                            'package_id' => $item->package_id,
                            'package_name' => $item->package->package_name ?? 'Gói tùy chỉnh',
                            'start_date' => $item->start_date,
                            'end_date' => $item->end_date,
                            'status' => $item->status
                        ];
                    @endphp

                    {{-- Row --}}
                    <tr class="{{ $rowBg }} cursor-pointer transition-colors" onclick='openEditRegistrationModal(@json($editData))'>
                        
                        {{-- ID --}}
                        <td class="py-4 px-4 truncate align-middle {{ $roundLeft }} font-medium">{{ $formattedId }}</td>
                        
                        {{-- Khách hàng --}}
                        <td class="py-4 px-4 truncate align-middle font-medium">{{ $item->user->full_name ?? 'N/A' }}</td>
                        
                        {{-- Gói tập --}}
                        <td class="py-4 px-4 truncate align-middle">{{ $item->package->package_name ?? 'N/A' }}</td>
                        
                        {{-- Ngày bắt đầu --}}
                        <td class="py-4 px-4 truncate align-middle">{{ \Carbon\Carbon::parse($item->start_date)->format('d/m/Y') }}</td>
                        
                        {{-- Ngày kết thúc --}}
                        <td class="py-4 px-4 truncate align-middle">{{ \Carbon\Carbon::parse($item->end_date)->format('d/m/Y') }}</td>
                        
                        {{-- Trạng thái --}}
                        <td class="py-4 px-4 truncate align-middle {{ $roundRight }}">
                            @switch($item->status)
                                @case('active') 
                                    {{-- Màu xanh dương --}}
                                    <span class="bg-[#4A90E2]/10 text-[#4A90E2]/70 py-1 px-3 rounded-full text-sm font-semibold">
                                        Còn hạn
                                    </span> 
                                    @break
                                @case('completed') 
                                    {{-- Màu xanh lá --}}
                                    <span class="bg-[#28A745]/10 text-[#28A745]/70 py-1 px-3 rounded-full text-sm font-semibold">
                                        Hoàn thành
                                    </span> 
                                    @break
                                @case('expired') 
                                    {{-- Màu đỏ --}}
                                    <span class="bg-[#DC3545]/10 text-[#DC3545]/70 py-1 px-3 rounded-full text-sm font-semibold">
                                        Hết hạn
                                    </span> 
                                    @break
                                @default 
                                    <span class="bg-gray-100 text-gray-500 py-1 px-3 rounded-full text-sm font-semibold">N/A</span>
                            @endswitch
                        </td>
                    </tr>
                    {{-- Spacer Row --}}
                    <tr class="h-2"></tr>
                @endforeach
            </tbody>
            
        </table>

        {{-- Pagination --}}
        <div class="mt-4 flex justify-center">
            {{ $registrations->links() }}
        </div>

    </div>
</div>

{{-- Include Modal Templates --}}
@include('admin.partials.add_package_registration_modal') 
@include('admin.partials.edit_package_registration_modal')

<script>
    // --- 1. CORE LOGIC (RegistrationApp) ---
    const RegistrationApp = {
        // Toggle Modal Visibility
        toggleModal: function(modalID) {
            const modal = document.getElementById(modalID);
            if(modal) modal.classList.toggle('hidden');
        },

        // Toggle Dropdown (Custom Select)
        toggleDropdown: function(targetId) {
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

        // Select Item logic for Custom Dropdowns
        selectItem: function(config) {
            // Set value input hidden
            const hiddenInput = document.getElementById(config.inputId);
            if(hiddenInput) hiddenInput.value = config.value;

            // Set display text
            const displayEl = document.getElementById(config.displayId);
            if(displayEl) {
                displayEl.innerText = (config.text && config.text !== 'N/A') ? config.text : "Chọn...";
                displayEl.classList.toggle('text-gray-500', !config.value);
                displayEl.classList.toggle('text-black', !!config.value);
            }

            // Close dropdown
            if(config.dropdownId) {
                const dropdown = document.getElementById(config.dropdownId);
                if(dropdown) dropdown.classList.add('hidden');
            }
        },

        // Filter List logic
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

    // --- 2. EVENT BINDINGS ---
    
    // Close dropdowns when clicking outside
    window.addEventListener('click', function(e) {
        if (!e.target.closest('.dropdown-container')) {
            document.querySelectorAll('.dropdown-panel').forEach(el => el.classList.add('hidden'));
        }
    });

    // Wrapper Functions for HTML onclick attributes
    function toggleModal(id) { RegistrationApp.toggleModal(id); }
    function toggleDropdown(id) { RegistrationApp.toggleDropdown(id); }

    // Wrappers for ADD Modal (User & Package)
    function filterUsers() { RegistrationApp.filterList('user-search', 'user-list'); }
    function selectUser(id, name) { RegistrationApp.selectItem({inputId: 'selected_user_id', displayId: 'user-display', dropdownId: 'user-options', value: id, text: name}); }
    
    function filterPackages() { RegistrationApp.filterList('package-search', 'package-list'); }
    function selectPackage(id, name) { RegistrationApp.selectItem({inputId: 'selected_package_id', displayId: 'package-display', dropdownId: 'package-options', value: id, text: name}); }

    // Wrappers for EDIT Modal
    function filterEditUsers() { RegistrationApp.filterList('edit-user-search', 'edit-user-list'); }
    function selectEditUser(id, name) { RegistrationApp.selectItem({inputId: 'edit_selected_user_id', displayId: 'edit-user-display', dropdownId: 'edit-user-options', value: id, text: name}); }
    
    function filterEditPackages() { RegistrationApp.filterList('edit-package-search', 'edit-package-list'); }
    function selectEditPackage(id, name) { RegistrationApp.selectItem({inputId: 'edit_selected_package_id', displayId: 'edit-package-display', dropdownId: 'edit-package-options', value: id, text: name}); }

    // --- 3. SPECIFIC LOGIC FOR EDITING ---

    // Hàm mở Modal Sửa và fill dữ liệu
    function openEditRegistrationModal(data) {
        console.log("Edit Registration:", data);

        toggleModal('edit-package-modal'); // ID modal trong file include

        // 1. Set Form Action (Dynamic ID)
        const form = document.querySelector('#edit-package-modal form');
        if(form) form.action = `/admin/package_registration/${data.id}`;

        // 2. Fill Input Fields
        if(document.getElementById('display_id')) document.getElementById('display_id').value = data.formatted_id;
        
        // Date inputs
        const startDateInput = document.getElementById('edit_start_date');
        const endDateInput = document.getElementById('edit_end_date');

        if(startDateInput) {
            startDateInput.value = data.start_date ? data.start_date.split(' ')[0] : '';
            // Disable:
            startDateInput.disabled = true;
            startDateInput.classList.add('bg-gray-100', 'cursor-not-allowed', 'text-gray-500');
            startDateInput.classList.remove('bg-white');
        }

        if(endDateInput) {
            endDateInput.value = data.end_date ? data.end_date.split(' ')[0] : '';
            // Disable:
            endDateInput.disabled = true;
            endDateInput.classList.add('bg-gray-100', 'cursor-not-allowed', 'text-gray-500');
            endDateInput.classList.remove('bg-white');
        }

        // Status Select
        if(document.getElementById('edit_status')) document.getElementById('edit_status').value = data.status;

        // 3. Fill Custom Dropdowns (User & Package)
        
        // Khách hàng
        RegistrationApp.selectItem({
            inputId: 'edit_selected_user_id',
            displayId: 'edit-user-display',
            value: data.user_id,
            text: data.user_name
        });
        disableCustomDropdown('edit-user-dropdown-container');

        // Gói tập
        RegistrationApp.selectItem({
            inputId: 'edit_selected_package_id',
            displayId: 'edit-package-display',
            value: data.package_id,
            text: data.package_name
        });
        disableCustomDropdown('edit-package-dropdown-container');
    }

    // --- HÀM HỖ TRỢ KHÓA DROPDOWN (Thêm mới) ---
    function disableCustomDropdown(containerId) {
        const container = document.getElementById(containerId);
        if (container) {
            const btn = container.querySelector('button');
            if (btn) {
                // 1. Vô hiệu hóa nút
                btn.disabled = true;
                btn.removeAttribute('onclick'); // Xóa sự kiện click
                
                // 2. Chỉnh giao diện sang màu xám (giống ô ID)
                btn.classList.add('bg-gray-100', 'cursor-not-allowed', 'text-gray-500');
                btn.classList.remove('bg-white', 'hover:border-blue-400');
                
                // 3. Đổi màu icon mũi tên cho nhạt đi
                const icon = btn.querySelector('svg');
                if(icon) icon.classList.add('text-gray-400');
            }
        }
    }

    // --- 4. DELETE LOGIC ---
    document.addEventListener('DOMContentLoaded', function() {
        const deleteBtn = document.getElementById('btn-delete-registration');
        if (deleteBtn) {
            deleteBtn.addEventListener('click', function() {
                const form = document.querySelector('#edit-package-modal form');
                const actionUrl = form.getAttribute('action'); 
                
                if (!actionUrl) return;
                if (!confirm('Bạn có chắc chắn muốn hủy đăng ký gói này không? Dữ liệu sẽ bị xóa vĩnh viễn.')) return;

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
                        alert('Xóa thành công!');
                        location.reload();
                    } else {
                        alert('Lỗi: ' + (data.message || 'Không xác định'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Lỗi kết nối server.');
                });
            });
        }
    });
</script>

@endsection