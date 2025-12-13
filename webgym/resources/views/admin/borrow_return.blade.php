@extends('layouts.ad_layout')

@section('title', 'Quản lý mượn trả')

@section('content')

{{-- CSRF TOKEN --}}
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="bg-white rounded-2xl shadow-sm p-6">
    
    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="font-montserrat text-2xl text-black font-semibold">Quản lý mượn trả đồ</h1>
        
        <div class="flex items-center space-x-4 font-open-sans">
            {{-- Filter --}}
            <div class="flex items-center text-black cursor-pointer hover:text-gray-900">
                <span class="mr-1 text-sm font-medium">Hôm nay</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </div>

            {{-- Nút Thêm --}}
            <button onclick="BorrowApp.toggleModal('add-borrow-modal')" class="bg-[#28A745] hover:bg-[#218838] text-white px-4 py-2 rounded-full flex items-center text-sm font-semibold transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Mượn đồ
            </button>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse table-auto font-open-sans">
            <thead class="font-montserrat text-[#1f1d1d] text-sm text-center">
                <tr>
                    <th class="py-4 px-4 w-[10%] truncate">Mã GD</th>                  
                    <th class="py-4 px-4 w-[20%] truncate">Khách hàng</th> 
                    <th class="py-4 px-4 w-[20%] truncate">Vật phẩm</th>                    
                    <th class="py-4 px-4 w-[10%] truncate">Số lượng</th>                    
                    <th class="py-4 px-4 w-[15%] truncate">Ngày mượn</th>                    
                    <th class="py-4 px-4 w-[15%] truncate">Ngày trả</th>                    
                    <th class="py-4 px-4 w-[10%] truncate">Trạng thái</th>
                </tr>
            </thead>
           
            <tbody class="text-sm text-gray-700 text-center">
                @foreach($transactions as $item)
                    @php
                        $formattedId = 'RT' . str_pad($item->transaction_id, 4, '0', STR_PAD_LEFT);
                        $isOdd = $loop->odd;
                        $rowBg = $isOdd ? 'bg-[#1976D2]/20' : 'bg-white'; 
                        $roundLeft = $isOdd ? 'rounded-l-xl' : '';
                        $roundRight = $isOdd ? 'rounded-r-xl' : '';

                        // Data for Edit Modal
                        $editData = [
                            'id' => $item->transaction_id,
                            'formatted_id' => $formattedId,
                            'user_name' => $item->user->full_name ?? 'Khách lẻ',
                            'item_name' => $item->item->item_name ?? 'Vật phẩm đã xóa',
                            'quantity' => $item->quantity,
                            'borrow_date' => $item->borrow_date,
                            'return_date' => $item->return_date,
                            'status' => $item->status,
                            'note' => $item->note
                        ];
                    @endphp

                    <tr class="{{ $rowBg }} cursor-pointer transition-colors" onclick='openEditModal(@json($editData))'>
                        <td class="py-4 px-4 truncate align-middle {{ $roundLeft }} font-medium">{{ $formattedId }}</td>
                        <td class="py-4 px-4 truncate align-middle font-medium">{{ $item->user->full_name ?? 'N/A' }}</td>
                        <td class="py-4 px-4 truncate align-middle">{{ $item->item->item_name ?? 'N/A' }}</td>
                        <td class="py-4 px-4 truncate align-middle">{{ $item->quantity }}</td>
                        <td class="py-4 px-4 truncate align-middle">{{ \Carbon\Carbon::parse($item->borrow_date)->format('d/m/Y') }}</td>
                        <td class="py-4 px-4 truncate align-middle">
                            {{ $item->return_date ? \Carbon\Carbon::parse($item->return_date)->format('d/m/Y') : '-' }}
                        </td>
                        <td class="py-4 px-4 truncate align-middle {{ $roundRight }}">
                            @if($item->status == 'renting')
                                <span class="bg-[#FFC107]/10 text-[#FFC107]/90 py-1 px-3 rounded-full text-sm font-semibold">Đang thuê</span>
                            @else
                                <span class="bg-[#28A745]/10 text-[#28A745]/90 py-1 px-3 rounded-full text-sm font-semibold">Đã trả</span>
                            @endif
                        </td>
                    </tr>
                    <tr class="h-2"></tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4 flex justify-center">
            {{ $transactions->links() }}
        </div>
    </div>
</div>

{{-- ================= MODAL THÊM MỚI (MƯỢN ĐỒ) ================= --}}
<div id="add-borrow-modal" class="modal-container hidden fixed inset-0 z-50 items-center justify-center bg-black/40 transition-opacity">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-2xl transform transition-all scale-100">
        <h2 class="text-3xl font-bold text-center mb-6 bg-gradient-to-r from-[#0D47A1] to-[#42A5F5] bg-clip-text text-transparent font-montserrat">
            PHIẾU MƯỢN ĐỒ
        </h2>
        
        <form id="addBorrowForm">
            <div class="grid grid-cols-1 gap-5">
                {{-- 1. Chọn User --}}
                <div class="flex items-center space-x-4">
                    <label class="w-1/4 font-semibold text-gray-700">Khách hàng <span class="text-red-500">*</span></label>
                    <div class="w-3/4 relative dropdown-container">
                        <input type="hidden" id="add_user_id" name="user_id">
                        <button type="button" onclick="BorrowApp.toggleDropdown('add-user-dropdown')" class="w-full bg-white border border-gray-300 rounded-xl px-4 py-2.5 text-left flex justify-between items-center focus:ring-2 focus:ring-blue-500">
                            <span id="add-user-display" class="text-gray-500">Chọn khách hàng...</span>
                            <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                        </button>
                        <div id="add-user-dropdown" class="dropdown-panel hidden absolute z-20 w-full mt-1 bg-white border border-gray-200 rounded-xl shadow-xl overflow-hidden">
                            <div class="p-2 border-b border-gray-100">
                                <input type="text" id="user-search" onkeyup="BorrowApp.filterList('user-search', 'user-list')" placeholder="Tìm tên..." class="w-full px-3 py-1.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500">
                            </div>
                            <ul id="user-list" class="max-h-48 overflow-y-auto">
                                @foreach($users as $u)
                                    <li onclick="BorrowApp.selectItem('add_user_id', 'add-user-display', 'add-user-dropdown', '{{ $u->id }}', '{{ $u->full_name }}')" 
                                        class="px-4 py-2.5 hover:bg-blue-50 cursor-pointer text-gray-700 text-sm border-b border-gray-50 last:border-0">
                                        {{ $u->full_name }} <span class="text-gray-400 text-xs">({{ $u->phone }})</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- 2. Chọn Chi Nhánh (MỚI) --}}
                <div class="flex items-center space-x-4">
                    <label class="w-1/4 font-semibold text-gray-700">Chi nhánh <span class="text-red-500">*</span></label>
                    <div class="w-3/4 relative dropdown-container">
                        <input type="hidden" id="add_branch_id">
                        <button type="button" onclick="BorrowApp.toggleDropdown('add-branch-dropdown')" class="w-full bg-white border border-gray-300 rounded-xl px-4 py-2.5 text-left flex justify-between items-center focus:ring-2 focus:ring-blue-500">
                            <span id="add-branch-display" class="text-gray-500">Chọn chi nhánh...</span>
                            <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                        </button>
                        <div id="add-branch-dropdown" class="dropdown-panel hidden absolute z-20 w-full mt-1 bg-white border border-gray-200 rounded-xl shadow-xl overflow-hidden">
                            <ul id="branch-list" class="max-h-48 overflow-y-auto">
                                @foreach($branches as $branch)
                                    {{-- Gọi hàm selectBranch khi chọn --}}
                                    <li onclick="selectBranch('{{ $branch->branch_id }}', '{{ $branch->branch_name }}')" 
                                        class="px-4 py-2.5 hover:bg-blue-50 cursor-pointer text-gray-700 text-sm border-b border-gray-50 last:border-0">
                                        {{ $branch->branch_name }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- 3. Chọn Vật phẩm (Sẽ load động) --}}
                <div class="flex items-center space-x-4">
                    <label class="w-1/4 font-semibold text-gray-700">Vật phẩm <span class="text-red-500">*</span></label>
                    <div class="w-3/4 relative dropdown-container">
                        <input type="hidden" id="add_item_id" name="item_id">
                        {{-- Disabled ban đầu, chờ chọn chi nhánh --}}
                        <button type="button" id="btn-select-item" disabled onclick="BorrowApp.toggleDropdown('add-item-dropdown')" class="w-full bg-gray-100 cursor-not-allowed border border-gray-300 rounded-xl px-4 py-2.5 text-left flex justify-between items-center focus:ring-2 focus:ring-blue-500">
                            <span id="add-item-display" class="text-gray-400">Vui lòng chọn chi nhánh trước</span>
                            <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                        </button>
                        <div id="add-item-dropdown" class="dropdown-panel hidden absolute z-20 w-full mt-1 bg-white border border-gray-200 rounded-xl shadow-xl overflow-hidden">
                            <div class="p-2 border-b border-gray-100">
                                <input type="text" id="item-search" onkeyup="BorrowApp.filterList('item-search', 'item-list')" placeholder="Tìm đồ..." class="w-full px-3 py-1.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500">
                            </div>
                            <ul id="item-list" class="max-h-48 overflow-y-auto">
                                {{-- Danh sách sẽ được JS render lại --}}
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- 4. Số lượng & Ngày mượn --}}
                <div class="flex space-x-6">
                    <div class="w-1/2 flex flex-col">
                        <label class="text-sm font-semibold text-gray-700 mb-1">Số lượng <span class="text-red-500">*</span></label>
                        <input type="number" id="add_quantity" value="1" min="1" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div class="w-1/2 flex flex-col">
                        <label class="text-sm font-semibold text-gray-700 mb-1">Ngày mượn <span class="text-red-500">*</span></label>
                        <input type="date" id="add_borrow_date" value="{{ date('Y-m-d') }}" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                </div>

                {{-- 5. Ghi chú --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Ghi chú</label>
                    <textarea id="add_note" rows="2" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none resize-none"></textarea>
                </div>
            </div>

            {{-- Footer Buttons --}}
            <div class="flex justify-center space-x-3 mt-8 pt-4 border-t border-gray-100">
                <button type="button" onclick="BorrowApp.toggleModal('add-borrow-modal')" class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-lg transition-colors">Hủy</button>
                <button type="submit" class="px-6 py-2.5 bg-[#28A745] hover:bg-[#218838] text-white font-semibold rounded-lg shadow-md transition-colors">Tạo phiếu</button>
            </div>
        </form>
    </div>
</div>

{{-- ================= MODAL SỬA/TRẢ ĐỒ ================= --}}
<div id="edit-borrow-modal" class="modal-container hidden fixed inset-0 z-50 items-center justify-center bg-black/40 transition-opacity">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-2xl transform transition-all scale-100">
        <h2 class="text-3xl font-bold text-center mb-6 bg-gradient-to-r from-[#0D47A1] to-[#42A5F5] bg-clip-text text-transparent font-montserrat">
            CHI TIẾT GIAO DỊCH
        </h2>
        
        <form id="editBorrowForm">
            <input type="hidden" id="edit_transaction_id">
            
            <div class="grid grid-cols-1 gap-5">
                {{-- Info Row --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Mã giao dịch</label>
                        <input type="text" id="display_id" class="w-full bg-gray-100 border border-gray-300 rounded-xl px-4 py-2.5 text-gray-700 font-mono outline-none cursor-not-allowed" disabled>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Khách hàng</label>
                        <input type="text" id="display_user" class="w-full bg-gray-100 border border-gray-300 rounded-xl px-4 py-2.5 text-gray-700 font-medium outline-none cursor-not-allowed" disabled>
                    </div>
                </div>

                <div class="flex space-x-6">
                    <div class="w-1/2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Vật phẩm</label>
                        <input type="text" id="display_item" class="w-full bg-gray-100 border border-gray-300 rounded-xl px-4 py-2.5 text-gray-500 cursor-not-allowed" disabled>
                    </div>
                    <div class="w-1/2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Số lượng</label>
                        <input type="text" id="display_quantity" class="w-full bg-gray-100 border border-gray-300 rounded-xl px-4 py-2.5 text-gray-500 cursor-not-allowed" disabled>
                    </div>
                </div>

                <div class="flex space-x-6">
                    <div class="w-1/2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Ngày mượn</label>
                        <input type="text" id="display_borrow_date" class="w-full bg-gray-100 border border-gray-300 rounded-xl px-4 py-2.5 text-gray-500 cursor-not-allowed" disabled>
                    </div>
                    <div class="w-1/2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Ngày trả (Thực tế)</label>
                        <input type="text" id="display_return_date" placeholder="Chưa trả" class="w-full bg-gray-100 border border-gray-300 rounded-xl px-4 py-2.5 text-gray-500 cursor-not-allowed" disabled>
                    </div>
                </div>

                {{-- Status Change --}}
                <div>
                    <label class="block text-sm font-bold text-gray-800 mb-2">Cập nhật trạng thái</label>
                    <select id="edit_status" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-500 font-medium">
                        <option value="renting" class="text-yellow-600">Đang thuê</option>
                        <option value="returned" class="text-green-600">Đã trả (Hoàn tất)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Ghi chú</label>
                    <textarea id="edit_note" rows="2" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none resize-none"></textarea>
                </div>
            </div>

            {{-- Footer --}}
            <div class="flex justify-between items-center mt-8 pt-4 border-t border-gray-100">
                <button type="button" id="btn-delete-transaction" class="px-4 py-2.5 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 font-semibold text-sm transition-colors">
                    Xóa phiếu
                </button>
                <div class="flex space-x-3">
                    <button type="button" onclick="BorrowApp.toggleModal('edit-borrow-modal')" class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-lg transition-colors">Đóng</button>
                    <button type="submit" class="px-6 py-2.5 bg-[#28A745] hover:bg-[#218838] text-white font-semibold rounded-lg shadow-md transition-colors">Cập nhật</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    // 1. Lấy dữ liệu Items từ PHP sang JS
    const globalItems = @json($items);

    const BorrowApp = {
        toggleModal: (id) => {
            const modal = document.getElementById(id);
            if (modal.classList.contains('hidden')) {
                modal.classList.remove('hidden');
                modal.classList.add('flex'); 
            } else {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        },
        
        toggleDropdown: (id) => {
            document.querySelectorAll('.dropdown-panel').forEach(p => { if(p.id !== id) p.classList.add('hidden'); });
            document.getElementById(id).classList.toggle('hidden');
        },

        selectItem: (inputId, displayId, dropdownId, value, text) => {
            document.getElementById(inputId).value = value;
            const display = document.getElementById(displayId);
            display.innerText = text;
            display.classList.remove('text-gray-500', 'text-gray-400');
            display.classList.add('text-black');
            document.getElementById(dropdownId).classList.add('hidden');
        },

        filterList: (inputId, listId) => {
            const filter = document.getElementById(inputId).value.toLowerCase();
            const items = document.getElementById(listId).getElementsByTagName('li');
            for (let i = 0; i < items.length; i++) {
                const txt = items[i].textContent || items[i].innerText;
                items[i].style.display = txt.toLowerCase().indexOf(filter) > -1 ? "" : "none";
            }
        }
    };

    // 2. Chọn Chi nhánh - Lọc Vật phẩm
    function selectBranch(branchId, branchName) {
        // 1. Set giá trị cho ô Chi nhánh
        BorrowApp.selectItem('add_branch_id', 'add-branch-display', 'add-branch-dropdown', branchId, branchName);

        // 2. Reset ô Vật phẩm
        document.getElementById('add_item_id').value = '';
        const itemDisplay = document.getElementById('add-item-display');
        itemDisplay.innerText = 'Chọn đồ thuê...';
        itemDisplay.classList.add('text-gray-500');
        itemDisplay.classList.remove('text-black', 'text-gray-400');

        // 3. Enable nút chọn vật phẩm
        const btnItem = document.getElementById('btn-select-item');
        btnItem.disabled = false;
        btnItem.classList.remove('bg-gray-100', 'cursor-not-allowed');
        btnItem.classList.add('bg-white');

        // 4. Lọc danh sách Item theo branch_id
        const filteredItems = globalItems.filter(item => item.branch_id == branchId);
        
        // 5. Render lại danh sách UL
        const itemListUl = document.getElementById('item-list');
        itemListUl.innerHTML = ''; 

        if (filteredItems.length === 0) {
            itemListUl.innerHTML = '<li class="px-4 py-2 text-gray-500 text-sm italic">Không có đồ tại chi nhánh này</li>';
        } else {
            filteredItems.forEach(item => {
                const li = document.createElement('li');
                li.className = 'px-4 py-2.5 hover:bg-blue-50 cursor-pointer text-gray-700 text-sm border-b border-gray-50 last:border-0';
                li.innerHTML = `${item.item_name} <span class="text-green-600 font-bold text-xs ml-2">Kho: ${item.quantity_available}</span>`;
                
                // Gán sự kiện click
                li.onclick = function() {
                    BorrowApp.selectItem(
                        'add_item_id', 
                        'add-item-display', 
                        'add-item-dropdown', 
                        item.item_id, 
                        `${item.item_name} (Kho: ${item.quantity_available})`
                    );
                    
                    document.getElementById('add_quantity').max = item.quantity_available;
                };
                itemListUl.appendChild(li);
            });
        }
    }

    // Close dropdowns on outside click
    window.addEventListener('click', (e) => {
        if (!e.target.closest('.dropdown-container')) {
            document.querySelectorAll('.dropdown-panel').forEach(el => el.classList.add('hidden'));
        }
    });

    // --- LOGIC ADD (SUBMIT) ---
    document.getElementById('addBorrowForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const fd = new FormData();
        fd.append('user_id', document.getElementById('add_user_id').value);
        fd.append('item_id', document.getElementById('add_item_id').value);
        fd.append('quantity', document.getElementById('add_quantity').value);
        fd.append('borrow_date', document.getElementById('add_borrow_date').value);
        fd.append('note', document.getElementById('add_note').value);

        fetch("{{ route('admin.borrow_return.store') }}", {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
            body: fd
        })
        .then(r => r.json())
        .then(d => {
            if(d.success) { alert('Thành công!'); location.reload(); }
            else alert(d.message);
        })
        .catch(e => alert('Lỗi hệ thống'));
    });

    // --- LOGIC EDIT ---
    function openEditModal(data) {
        BorrowApp.toggleModal('edit-borrow-modal');
        document.getElementById('edit_transaction_id').value = data.id;
        document.getElementById('display_id').value = data.formatted_id;     
        document.getElementById('display_user').value = data.user_name;
        document.getElementById('display_item').value = data.item_name;
        document.getElementById('display_quantity').value = data.quantity;
        document.getElementById('display_borrow_date').value = data.borrow_date.split(' ')[0].split('-').reverse().join('/');
        
        const returnDate = data.return_date ? data.return_date.split(' ')[0].split('-').reverse().join('/') : '';
        document.getElementById('display_return_date').value = returnDate;
        
        document.getElementById('edit_status').value = data.status;
        document.getElementById('edit_note').value = data.note || '';
    }

    document.getElementById('editBorrowForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const id = document.getElementById('edit_transaction_id').value;
        const fd = new FormData();
        fd.append('_method', 'PUT'); // Method spoofing
        fd.append('status', document.getElementById('edit_status').value);
        fd.append('note', document.getElementById('edit_note').value);

        fetch(`/admin/borrow_return/${id}`, { // Lưu ý route update
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
            body: fd
        })
        .then(r => r.json())
        .then(d => {
            if(d.success) { alert('Cập nhật thành công!'); location.reload(); }
            else alert(d.message);
        })
        .catch(e => alert('Lỗi hệ thống'));
    });

    // --- LOGIC DELETE ---
    document.getElementById('btn-delete-transaction').addEventListener('click', function() {
        if(!confirm('Xóa phiếu mượn này? Nếu đang mượn, kho sẽ được cộng lại.')) return;
        const id = document.getElementById('edit_transaction_id').value;
        
        fetch(`/admin/borrow_return/${id}`, {
            method: 'DELETE',
            headers: { 
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            }
        })
        .then(r => r.json())
        .then(d => {
            if(d.success) { alert('Đã xóa!'); location.reload(); }
            else alert(d.message);
        });
    });
</script>

@endsection