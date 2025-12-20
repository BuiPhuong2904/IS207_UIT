@extends('layouts.ad_layout')

@section('title', 'Quản lý khách hàng')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="bg-white rounded-2xl shadow-sm p-6">
    
    <div class="flex justify-between items-center mb-6">
        <h1 class="font-montserrat text-2xl text-black font-semibold">Khách hàng thành viên</h1>
        
        <div class="flex items-center space-x-4 font-open-sans">
            <div class="flex items-center text-black cursor-pointer hover:text-gray-900">
                <span class="mr-1 text-sm font-medium">Hôm nay</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </div>

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
                    <th class="py-4 px-4 w-[10%]">Mã KH</th>
                    <th class="py-4 px-4 w-[15%]">Họ và tên</th>
                    <th class="py-4 px-4 w-[20%]">Email</th>
                    <th class="py-4 px-4 w-[12%]">SĐT</th>
                    <th class="py-4 px-4 flex-1">Địa chỉ</th>
                </tr>
            </thead>

            <tbody class="text-sm text-gray-700 text-center">
                @foreach ($customers as $customer)
                @php
                    $isOdd = $loop->odd;
                    $rowBg = $isOdd ? 'bg-[#1976D2]/20' : 'bg-white';
                    $roundLeft = $isOdd ? 'rounded-l-xl' : '';
                    $roundRight = $isOdd ? 'rounded-r-xl' : '';
                @endphp

                <tr class="{{ $rowBg }} cursor-pointer transition-colors modal-trigger"
                    data-id="{{ $customer->id }}"
                    data-name="{{ $customer->full_name }}"
                    data-email="{{ $customer->email }}"
                    data-phone="{{ $customer->phone }}"
                    data-address="{{ $customer->address }}"
                    data-avatar="{{ $customer->image_url }}"
                    data-packages="{{ 
                        $customer->packageRegistrations
                            ->pluck('package.package_name')
                            ->join(', ')
                    }}"
                    data-classes="{{ 
                        $customer->classRegistrations->count() > 0 
                            ? $customer->classRegistrations->pluck('id')->join(', ')
                            : 'Chưa tham gia'
                    }}"
                >


                    <td class="py-4 px-4 {{ $roundLeft }} font-medium">
                        KH{{ str_pad($customer->id, 4, '0', STR_PAD_LEFT) }}
                    </td>

                    <td class="py-4 px-4 font-medium">
                        {{ $customer->full_name }}
                    </td>

                    <td class="py-4 px-4">
                        {{ $customer->email }}
                    </td>

                    <td class="py-4 px-4">
                        {{ $customer->phone ?? '—' }}
                    </td>

                    <td class="py-4 px-4 truncate text-center max-w-xs"
                        title="{{ $customer->address }}">
                        {{ $customer->address ?? '—' }}
                    </td>
                </tr>

                <tr class="h-2"></tr>
                @endforeach
                </tbody>

        </table>

        <div class="mt-6 flex justify-center">
            {{ $customers->links() }}
        </div>
    </div>
</div>

<div id="addUserModal"
     class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">

    <div class="bg-white w-full max-w-5xl rounded-3xl shadow-2xl overflow-hidden">

        <div class="py-6 text-center border-b">
            <h2 class="text-2xl font-bold text-blue-700 tracking-wide">
                THÊM KHÁCH HÀNG
            </h2>
        </div>

        <form id="addUserForm" class="p-8 space-y-8">

            <div>
                <h3 class="text-lg font-semibold text-blue-700 mb-4">
                    Thông tin cá nhân
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

                    <div class="flex flex-col items-center">
                        <div class="w-36 h-36 rounded-xl overflow-hidden border bg-gray-100">
                            <img id="add-user-avatar"
                                 src="https://via.placeholder.com/150"
                                 class="w-full h-full object-cover">
                        </div>
                        <span class="mt-2 text-xs text-gray-500">Ảnh đại diện</span>
                    </div>

                    <div class="md:col-span-3 grid grid-cols-1 md:grid-cols-2 gap-4">

                        <div>
                            <label class="text-sm font-medium text-gray-600">Họ và tên</label>
                            <input id="add-full_name"
                                   required
                                   class="w-full mt-1 rounded-lg border px-3 py-2">
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-600">Email</label>
                            <input id="add-email"
                                   type="email"
                                   required
                                   class="w-full mt-1 rounded-lg border px-3 py-2">
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-600">Mật khẩu</label>
                            <input id="add-password"
                                   type="password"
                                   required
                                   class="w-full mt-1 rounded-lg border px-3 py-2">
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-600">SĐT</label>
                            <input id="add-phone"
                                   class="w-full mt-1 rounded-lg border px-3 py-2">
                        </div>

                        <div class="md:col-span-2">
                            <label class="text-sm font-medium text-gray-600">Địa chỉ</label>
                            <input id="add-address"
                                   class="w-full mt-1 rounded-lg border px-3 py-2">
                        </div>

                    </div>
                </div>
            </div>

            <div class="flex justify-between pt-6 border-t">
                <button type="button"
                        class="close-modal px-6 py-2 rounded-lg bg-gray-300 hover:bg-gray-400 font-semibold">
                    Hủy
                </button>

                <button type="submit"
                        class="px-6 py-2 rounded-lg bg-green-600 hover:bg-green-700 text-white font-semibold">
                    Thêm khách hàng
                </button>
            </div>
        </form>
    </div>
</div>

<div id="manageUserModal"
     class="modal-container hidden fixed inset-0 z-50 items-center justify-center bg-black/40">

    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-y-auto">

        <h2 class="text-3xl font-bold text-center mb-6
            bg-gradient-to-r from-[#0D47A1] to-[#42A5F5]
            bg-clip-text text-transparent font-montserrat">
            QUẢN LÝ KHÁCH HÀNG
        </h2>

        <form id="manageUserForm">
            <input type="hidden" id="current-user-id">

            <h3 class="text-xl font-semibold text-blue-700 mb-4 font-montserrat">
                Thông tin cá nhân
            </h3>

            <div class="flex space-x-6 mb-6">

                <div class="w-40 flex-shrink-0 flex flex-col items-center">
                    <div class="w-40 h-40 bg-gray-100 rounded-2xl
                        flex items-center justify-center mb-3
                        border-2 border-dashed border-gray-300 overflow-hidden">
                        <img id="manage-user-avatar"
                             src="{{ asset('images/default-avatar.png') }}"
                             class="w-full h-full object-cover">
                    </div>
                </div>

                <div class="flex-1 flex flex-col space-y-4">

                    <div class="flex items-center space-x-6">
                        <div class="flex-1">
                            <label class="text-sm font-semibold text-gray-700">ID</label>
                            <input id="manage-user-code" disabled
                                   class="w-full bg-gray-100 border rounded-xl px-4 py-2.5 font-mono">
                        </div>
                        <div class="flex-1">
                            <label class="text-sm font-semibold text-gray-700">Họ và tên</label>
                            <input id="manage-user-name"
                                   class="w-full border rounded-xl px-4 py-2.5">
                        </div>
                    </div>

                    <div class="flex items-center space-x-6">
                        <div class="flex-1">
                            <label class="text-sm font-semibold text-gray-700">Email</label>
                            <input id="manage-user-email"
                                   class="w-full border rounded-xl px-4 py-2.5">
                        </div>
                        <div class="flex-1">
                            <label class="text-sm font-semibold text-gray-700">SĐT</label>
                            <input id="manage-user-phone"
                                   class="w-full border rounded-xl px-4 py-2.5">
                        </div>
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-gray-700">Địa chỉ</label>
                        <input id="manage-user-address"
                               class="w-full border rounded-xl px-4 py-2.5">
                    </div>

                </div>
            </div>

            <h3 class="text-xl font-semibold text-blue-700 mb-4 font-montserrat">
                Thông tin chung
            </h3>

            <div class="space-y-4 mb-6">
                <div>
                    <label class="text-sm font-semibold text-gray-700">
                        Gói tập đã đăng ký
                    </label>
                    <input id="manage-user-packages" readonly
                           class="w-full bg-gray-100 border rounded-xl px-4 py-2.5">
                </div>

                <div>
                    <label class="text-sm font-semibold text-gray-700">
                        Lớp học hiện hoạt
                    </label>
                    <input id="manage-user-classes" readonly
                           class="w-full bg-gray-100 border rounded-xl px-4 py-2.5">
                </div>
            </div>

            <div class="flex justify-end space-x-3 pt-4 border-t">
                <button type="button"
                        class="close-modal px-6 py-2.5 bg-gray-500 hover:bg-gray-600 text-white rounded-lg">
                    Hủy
                </button>
                <button type="submit"
                        class="px-6 py-2.5 bg-[#28A745] hover:bg-[#218838] text-white rounded-lg">
                    Lưu thông tin
                </button>
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
// ================= MODAL NOTIFY =================
function showNotify(message, type = 'success', callback = null) {
    const modal = document.getElementById('notifyModal');
    const title = document.getElementById('notifyTitle');
    const msg   = document.getElementById('notifyMessage');
    const btn   = document.getElementById('notifyCloseBtn');

    title.textContent = type === 'error' ? 'Lỗi' : 'Thông báo';
    title.className =
        'text-xl font-bold mb-2 ' +
        (type === 'error' ? 'text-red-600' : 'text-green-600');

    msg.textContent = message;

    modal.classList.remove('hidden');

    btn.onclick = () => {
        modal.classList.add('hidden');
        if (typeof callback === 'function') callback();
    };
}

document.addEventListener('DOMContentLoaded', () => {

    const manageUserModal = document.getElementById('manageUserModal');
    const addBtn   = document.getElementById('openAddModalBtn');
    const addModal = document.getElementById('addUserModal');

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
        .forEach(b => b.onclick = () => closeModal(b.closest('.modal-container')));

    document.querySelectorAll('tr.modal-trigger').forEach(row => {
        row.onclick = () => {
            const d = row.dataset;

            document.getElementById('current-user-id').value = d.id;
            document.getElementById('manage-user-code').value =
                'KH' + String(d.id).padStart(4, '0');
            document.getElementById('manage-user-name').value = d.name || '';
            document.getElementById('manage-user-email').value = d.email || '';
            document.getElementById('manage-user-phone').value = d.phone || '';
            document.getElementById('manage-user-address').value = d.address || '';
            document.getElementById('manage-user-packages').value =
                d.packages || 'Chưa đăng ký';
            document.getElementById('manage-user-classes').value =
                d.classes || 'Chưa tham gia';
                document.getElementById('manage-user-avatar').src =
            d.avatar && d.avatar !== ''
                ? d.avatar
                : '/images/default-avatar.png';

            openModal(manageUserModal);
        };
    });

    document.getElementById('addUserForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    const fd = new FormData();
    fd.append('full_name', document.getElementById('add-full_name').value);
    fd.append('email', document.getElementById('add-email').value);
    fd.append('password', document.getElementById('add-password').value);
    fd.append('phone', document.getElementById('add-phone').value);
    fd.append('address', document.getElementById('add-address').value);

    try {
        const res = await fetch('/admin/customers', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: fd
        });

        const data = await res.json();

        if (!res.ok) {
            alert(Object.values(data.errors || {}).join('\n'));
            return;
        }

        showNotify('Thêm khách hàng thành công', 'success', () => {
            location.reload();
        });

    } catch (err) {
        Object.values(data.errors || {}).flat()
            .forEach(msg => showNotify(msg, 'error'));
        console.error(err);
    }
});

document.getElementById('manageUserForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    const id = document.getElementById('current-user-id').value;

    const fd = new FormData();
    fd.append('_method', 'PUT');
    fd.append('full_name', document.getElementById('manage-user-name').value);
    fd.append('email', document.getElementById('manage-user-email').value);
    fd.append('phone', document.getElementById('manage-user-phone').value);
    fd.append('address', document.getElementById('manage-user-address').value);

    try {
        const res = await fetch(`/admin/customers/${id}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: fd
        });

        const data = await res.json();

        if (!res.ok) {
            alert(Object.values(data.errors || {}).join('\n'));
            return;
        }

        showNotify('Lưu thông tin khách hàng thành công', 'success', () => {
            location.reload();
        });

    } catch (err) {
        Object.values(data.errors || {}).flat()
            .forEach(msg => showNotify(msg, 'error'));
        console.error(err);
    }
});

});
</script>
@endpush