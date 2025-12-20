@extends('layouts.ad_layout')

@section('title', 'Quản lý Chi nhánh')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="bg-white rounded-2xl shadow-sm p-6">
    
    <div class="flex justify-between items-center mb-6">
        <h1 class="font-montserrat text-2xl text-black font-semibold">Chi nhánh</h1>
        
        <div class="flex items-center space-x-4 font-open-sans">
            <button id="openAddModalBtn" class="bg-[#28A745] hover:bg-[#218838] text-white px-4 py-2 rounded-full flex items-center text-sm font-semibold transition-colors shadow-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Thêm 
            </button>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse table-auto font-open-sans">
            
            <thead class="font-montserrat text-[#1f1d1d] text-sm text-center">
                <tr>
                    <th class="py-4 px-4 w-[10%]">Mã CN</th>
                    <th class="py-4 px-4 w-[20%]">Tên chi nhánh</th>
                    <th class="py-4 px-4 w-[25%]">Địa chỉ</th>
                    <th class="py-4 px-4 w-[15%]">Số điện thoại</th>
                    <th class="py-4 px-4 w-[15%]">Người quản lý</th>
                    <th class="py-4 px-4 w-[15%]">Trạng thái</th>
                </tr>
            </thead>

            <tbody class="text-sm text-gray-700 text-center">
                @foreach ($branches as $branch)
                @php
                    $isOdd = $loop->odd;
                    $rowBg = $isOdd ? 'bg-[#1976D2]/20' : 'bg-white';
                    $roundLeft = $isOdd ? 'rounded-l-xl' : '';
                    $roundRight = $isOdd ? 'rounded-r-xl' : '';
                @endphp

                <tr class="{{ $rowBg }} cursor-pointer transition-colors modal-trigger hover:opacity-80"
                    data-id="{{ $branch->branch_id }}"
                    data-name="{{ $branch->branch_name }}"
                    data-address="{{ $branch->address }}"
                    data-phone="{{ $branch->phone }}"
                    data-manager-id="{{ $branch->manager_id ??  '' }}"
                    data-manager="{{ $branch->manager ?  $branch->manager->full_name : '' }}"
                    data-active="{{ $branch->is_active }}"
                >
                    <td class="py-4 px-4 {{ $roundLeft }} font-medium">
                        CN{{ str_pad($branch->branch_id, 4, '0', STR_PAD_LEFT) }}
                    </td>

                    <td class="py-4 px-4 font-medium">
                        {{ $branch->branch_name }}
                    </td>

                    <td class="py-4 px-4 truncate max-w-xs"
                        title="{{ $branch->address }}">
                        {{ $branch->address }}
                    </td>

                    <td class="py-4 px-4">
                        {{ $branch->phone }}
                    </td>

                    <td class="py-4 px-4">
                        {{ $branch->manager ? $branch->manager->full_name : '—' }}
                    </td>

                    {{-- Trạng thái --}}
                    <td class="py-4 px-4 {{ $roundRight }}">
                        @if($branch->is_active)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Hoạt động
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                                Ngừng
                            </span>
                        @endif
                    </td>
                </tr>

                <tr class="h-2"></tr>
                @endforeach
            </tbody>

        </table>

        <div class="mt-6 flex justify-center">
            {{ $branches->links() }}
        </div>
    </div>
</div>

<div id="addBranchModal"
     class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">

    <div class="bg-white w-full max-w-3xl rounded-3xl shadow-2xl overflow-hidden">

        <div class="py-6 text-center border-b">
            <h2 class="text-2xl font-bold text-blue-700 tracking-wide">
                THÊM CHI NHÁNH
            </h2>
        </div>

        <form id="addBranchForm" class="p-8 space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <label class="text-sm font-medium text-gray-600">Tên chi nhánh <span class="text-red-500">*</span></label>
                    <input id="add-branch_name"
                           required
                           class="w-full mt-1 rounded-lg border px-3 py-2">
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-600">Số điện thoại <span class="text-red-500">*</span></label>
                    <input id="add-phone"
                           required
                           class="w-full mt-1 rounded-lg border px-3 py-2">
                </div>

                <div class="md:col-span-2">
                    <label class="text-sm font-medium text-gray-600">Địa chỉ <span class="text-red-500">*</span></label>
                    <input id="add-address"
                           required
                           class="w-full mt-1 rounded-lg border px-3 py-2">
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-600">Người quản lý</label>
                    <select id="add-manager_id"
                            class="w-full mt-1 rounded-lg border px-3 py-2">
                        <option value="">-- Chọn người quản lý --</option>
                        @foreach(\App\Models\User::where('role', 'admin')->get() as $manager)
                        <option value="{{ $manager->id }}">{{ $manager->full_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center">
                    <label class="text-sm font-medium text-gray-600 flex items-center cursor-pointer">
                        <input type="checkbox" id="add-is_active" checked
                               class="w-5 h-5 mr-2 rounded">
                        Đang hoạt động
                    </label>
                </div>

            </div>

            <div class="flex justify-between pt-6 border-t">
                <button type="button"
                        class="close-modal px-6 py-2 rounded-lg bg-gray-300 hover:bg-gray-400 font-semibold">
                    Hủy
                </button>

                <button type="submit"
                        class="px-6 py-2 rounded-lg bg-green-600 hover:bg-green-700 text-white font-semibold">
                    Thêm chi nhánh
                </button>
            </div>
        </form>
    </div>
</div>

<div id="manageBranchModal"
     class="modal-container hidden fixed inset-0 z-50 items-center justify-center bg-black/40">

    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-y-auto">

        <h2 class="text-3xl font-bold text-center mb-6
            bg-gradient-to-r from-[#0D47A1] to-[#42A5F5]
            bg-clip-text text-transparent font-montserrat">
            QUẢN LÝ CHI NHÁNH
        </h2>

        <form id="manageBranchForm">
            <input type="hidden" id="current-branch-id">

            <h3 class="text-xl font-semibold text-blue-700 mb-4 font-montserrat">
                Thông tin chi nhánh
            </h3>

            <div class="space-y-4 mb-6">

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-semibold text-gray-700">Mã chi nhánh</label>
                        <input id="manage-branch-code" disabled
                               class="w-full bg-gray-100 border rounded-xl px-4 py-2.5 font-mono">
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-700">Tên chi nhánh</label>
                        <input id="manage-branch-name"
                               class="w-full border rounded-xl px-4 py-2.5">
                    </div>
                </div>

                <div>
                    <label class="text-sm font-semibold text-gray-700">Địa chỉ</label>
                    <input id="manage-branch-address"
                           class="w-full border rounded-xl px-4 py-2.5">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-semibold text-gray-700">Số điện thoại</label>
                        <input id="manage-branch-phone"
                               class="w-full border rounded-xl px-4 py-2.5">
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-700">Người quản lý</label>
                        <select id="manage-branch-manager"
                                class="w-full border rounded-xl px-4 py-2.5">
                            <option value="">-- Chọn người quản lý --</option>
                            @foreach(\App\Models\User::where('role', 'admin')->get() as $manager)
                            <option value="{{ $manager->id }}">{{ $manager->full_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex items-center">
                    <label class="text-sm font-semibold text-gray-700 flex items-center cursor-pointer">
                        <input type="checkbox" id="manage-branch-active"
                               class="w-5 h-5 mr-2 rounded">
                        Đang hoạt động
                    </label>
                </div>

            </div>

            <div class="flex justify-between pt-4 border-t">
                <button type="button"
                        id="deleteBranchBtn"
                        class="px-6 py-2.5 bg-red-500 hover:bg-red-600 text-white rounded-lg font-semibold">
                    Xóa chi nhánh
                </button>

                <div class="flex space-x-3">
                    <button type="button"
                            class="close-modal px-6 py-2.5 bg-gray-500 hover:bg-gray-600 text-white rounded-lg">
                        Hủy
                    </button>
                    <button type="submit"
                            class="px-6 py-2.5 bg-[#28A745] hover:bg-[#218838] text-white rounded-lg">
                        Lưu thông tin
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>

<div id="notifyModal"
     class="hidden fixed inset-0 z-[9999] flex items-center justify-center bg-black/50">

    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6 text-center">

        <h3 id="notifyTitle"
            class="text-xl font-bold mb-2 text-green-600">
            Thông báo
        </h3>

        <p id="notifyMessage"
           class="text-gray-700 mb-6">
            Nội dung thông báo
        </p>

        <button id="notifyCloseBtn"
                class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold">
            OK
        </button>
    </div>
</div>

@endsection

@push('scripts')
<script>
function showNotify(message, type = 'success', callback = null) {
    const modal = document.getElementById('notifyModal');
    const title = document. getElementById('notifyTitle');
    const msg   = document.getElementById('notifyMessage');
    const btn   = document.getElementById('notifyCloseBtn');

    title.textContent = type === 'error' ? 'Lỗi' : 'Thông báo';
    title.className =
        'text-xl font-bold mb-2 ' +
        (type === 'error' ? 'text-red-600' : 'text-green-600');

    msg.textContent = message;

    modal.classList.remove('hidden');

    btn.onclick = () => {
        modal.classList. add('hidden');
        if (typeof callback === 'function') callback();
    };
}

document.addEventListener('DOMContentLoaded', () => {

    const manageBranchModal = document.getElementById('manageBranchModal');
    const addBtn   = document.getElementById('openAddModalBtn');
    const addModal = document.getElementById('addBranchModal');

    function openModal(m) {
        m.classList.remove('hidden');
        m.classList.add('flex');
    }

    function closeModal(m) {
        m.classList.add('hidden');
        m.classList.remove('flex');
    }

    addBtn.addEventListener('click', function () {
        openModal(addModal);
    });

    addModal.querySelectorAll('.close-modal').forEach(btn => {
        btn.addEventListener('click', () => closeModal(addModal));
    });

    addModal.addEventListener('click', e => {
        if (e.target === addModal) closeModal(addModal);
    });

    document.querySelectorAll('.close-modal')
        .forEach(b => b.onclick = () => closeModal(b. closest('.modal-container')));

    document.querySelectorAll('tr.modal-trigger').forEach(row => {
        row.onclick = () => {
            const d = row.dataset;

            document.getElementById('current-branch-id').value = d.id;
            document.getElementById('manage-branch-code').value =
                'CN' + String(d.id).padStart(4, '0');
            document.getElementById('manage-branch-name').value = d.name || '';
            document.getElementById('manage-branch-address').value = d.address || '';
            document. getElementById('manage-branch-phone').value = d.phone || '';
            document.getElementById('manage-branch-manager').value = d.managerId || '';
            document.getElementById('manage-branch-active').checked = d.active == '1';

            openModal(manageBranchModal);
        };
    });

    document.getElementById('addBranchForm').addEventListener('submit', async (e) => {
        e.preventDefault();

        const fd = new FormData();
        fd.append('branch_name', document.getElementById('add-branch_name').value);
        fd.append('address', document.getElementById('add-address').value);
        fd.append('phone', document.getElementById('add-phone').value);
        fd.append('manager_id', document.getElementById('add-manager_id').value);
        fd.append('is_active', document.getElementById('add-is_active').checked ? '1' : '0');

        try {
            const res = await fetch('/admin/branches', {
                method:  'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: fd
            });

            const data = await res.json();

            if (! res.ok) {
                const errors = data.errors || {};
                const errorMsg = Object.values(errors).flat().join('\n') || data.message || 'Có lỗi xảy ra';
                showNotify(errorMsg, 'error');
                return;
            }

            showNotify('Thêm chi nhánh thành công', 'success', () => {
                location.reload();
            });

        } catch (err) {
            showNotify('Có lỗi xảy ra', 'error');
            console.error(err);
        }
    });

    document.getElementById('manageBranchForm').addEventListener('submit', async (e) => {
        e.preventDefault();

        const id = document.getElementById('current-branch-id').value;

        const fd = new FormData();
        fd.append('_method', 'PUT');
        fd.append('branch_name', document.getElementById('manage-branch-name').value);
        fd.append('address', document.getElementById('manage-branch-address').value);
        fd.append('phone', document.getElementById('manage-branch-phone').value);
        fd.append('manager_id', document.getElementById('manage-branch-manager').value);
        fd.append('is_active', document.getElementById('manage-branch-active').checked ? '1' : '0');

        try {
            const res = await fetch(`/admin/branches/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: fd
            });

            const data = await res.json();

            if (!res.ok) {
                const errors = data.errors || {};
                const errorMsg = Object.values(errors).flat().join('\n') || data.message || 'Có lỗi xảy ra';
                showNotify(errorMsg, 'error');
                return;
            }

            showNotify('Cập nhật chi nhánh thành công', 'success', () => {
                location.reload();
            });

        } catch (err) {
            showNotify('Có lỗi xảy ra', 'error');
            console.error(err);
        }
    });

    document.getElementById('deleteBranchBtn').addEventListener('click', async () => {
        if (! confirm('Bạn có chắc chắn muốn xóa chi nhánh này? ')) return;

        const id = document.getElementById('current-branch-id').value;

        try {
            const res = await fetch(`/admin/branches/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document. querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            });

            const data = await res.json();

            if (!res.ok) {
                showNotify(data.message || 'Có lỗi xảy ra', 'error');
                return;
            }

            showNotify('Xóa chi nhánh thành công', 'success', () => {
                location.reload();
            });

        } catch (err) {
            showNotify('Có lỗi xảy ra', 'error');
            console.error(err);
        }
    });

});
</script>
@endpush