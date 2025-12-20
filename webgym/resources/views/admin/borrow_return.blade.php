@extends('layouts.ad_layout')

@section('title', 'Giao dịch mượn trả')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="bg-white rounded-2xl shadow-sm p-6">
    {{-- HEADER & BUTTONS --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="font-montserrat text-2xl text-black font-semibold">
            Giao dịch mượn trả
        </h1>

        <div class="flex items-center space-x-4 font-open-sans">

            <select id="filterSelect"
                class="px-4 py-2 text-sm focus:outline-none"
                onchange="location.href='?filter='+this.value">
                <option value="today" {{ ($filter ?? '') === 'today' ? 'selected' : '' }}>Hôm nay</option>
                <option value="7days" {{ ($filter ?? '') === '7days' ? 'selected' : '' }}>7 ngày</option>
                <option value="unreturned" {{ ($filter ?? '') === 'unreturned' ? 'selected' : '' }}>Chưa trả</option>
                <option value="all" {{ ($filter ?? '') === 'all' ? 'selected' : '' }}>Tất cả</option>
            </select>

            <button id="openAddBorrowModal"
                class="bg-[#28A745] hover:bg-[#218838] text-white px-4 py-2 rounded-full
                    flex items-center text-sm font-semibold transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 mr-1" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 4v16m8-8H4" />
                </svg>
                Thêm
            </button>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full border-collapse table-auto font-open-sans">
            {{-- HEADER --}}
            <thead class="bg-gray-100 text-gray-700 text-center">
                <tr>
                    <th class="py-4 px-4 w-[10%]">ID</th>
                    <th class="py-4 px-4 w-[20%]">Tên vật dụng</th>
                    <th class="py-4 px-4 w-[20%]">Tên khách hàng</th>
                    <th class="py-4 px-4 w-[10%]">Số lượng</th>
                    <th class="py-4 px-4 w-[15%]">Ngày mượn</th>
                    <th class="py-4 px-4 w-[15%]">Ngày trả</th>
                    <th class="py-4 px-4 w-[10%]">Trạng thái</th>
                </tr>
            </thead>

            <tbody class="text-sm text-gray-700 text-center">
                @forelse ($transactions as $t)
                @php
                    $rowBg = $loop->odd ? 'bg-[#1976D2]/20' : 'bg-white';
                @endphp

                {{-- mỗi row có data-* cần thiết để fill form --}}
                <tr class="{{ $rowBg }} cursor-pointer transition-colors borrow-row"
                    data-id="{{ $t->transaction_id }}"
                    data-item-id="{{ $t->item->item_id ?? '' }}"
                    data-item="{{ $t->item->item_name ?? '' }}"
                    data-user-id="{{ $t->user->id ?? '' }}"
                    data-user="{{ $t->user->full_name ?? '' }}"
                    data-qty="{{ $t->quantity }}"
                    data-borrow="{{ $t->borrow_date }}"
                    data-return="{{ $t->return_date }}"
                    data-status="{{ $t->status }}"
                    data-note="{{ $t->note }}">

                    <td class="py-4 px-4 rounded-l-xl font-medium">
                        MD{{ str_pad($t->transaction_id, 4, '0', STR_PAD_LEFT) }}
                    </td>

                    <td class="py-4 px-4 text-left pl-8">{{ $t->item->item_name ?? '—' }}</td>
                    <td class="py-4 px-4 text-left pl-8">{{ $t->user->full_name ?? '—' }}</td>
                    <td class="py-4 px-4">{{ $t->quantity }}</td>

                    <td class="py-4 px-4">
                        {{ \Carbon\Carbon::parse($t->borrow_date)->format('d/m/Y') }}
                    </td>

                    <td class="py-4 px-4">
                        {{ $t->return_date
                            ? \Carbon\Carbon::parse($t->return_date)->format('d/m/Y')
                            : '—'
                        }}
                    </td>

                    <td class="py-4 px-4 rounded-r-xl">
                        @if ($t->status === 'returned')
                            <span class="px-3 py-1 rounded-full text-xs bg-green-100 text-green-700">
                                Đã trả
                            </span>
                        @else
                            <span class="px-3 py-1 rounded-full text-xs bg-red-100 text-red-700">
                                Chưa trả
                            </span>
                        @endif
                    </td>
                </tr>

                <tr class="h-2"></tr>
                @empty
                <tr>
                    <td colspan="7" class="py-6 text-gray-500">
                        Không có giao dịch mượn trả
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div id="detailModal"
     class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">

    <div class="bg-white w-full max-w-3xl rounded-3xl shadow-2xl overflow-hidden">

        <div class="flex items-center justify-between px-6 py-4 border-b">
            <div>
                <h3 class="text-xl font-bold text-blue-700">
                    Chi tiết giao dịch mượn trả
                </h3>
                <p class="text-sm text-gray-500">
                    Thông tin chi tiết giao dịch
                </p>
            </div>

            <button id="closeDetailBtn"
                class="w-9 h-9 flex items-center justify-center rounded-full
                       hover:bg-gray-100 text-gray-500 text-xl">
                &times;
            </button>
        </div>

        <div class="p-6 space-y-6 text-sm">

            <div class="flex items-center justify-between">
                <div class="text-gray-500">
                    Mã giao dịch
                </div>
                <div class="font-semibold text-gray-800" id="vId"></div>
            </div>

            <div class="flex items-center justify-between">
                <div class="text-gray-500">
                    Trạng thái
                </div>
                <span id="vStatus"
                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold">
                </span>
            </div>

            <hr>

            <div class="grid grid-cols-2 gap-4">

                <div>
                    <div class="text-gray-500 mb-1">Khách hàng</div>
                    <div class="font-medium text-gray-800" id="vUser"></div>
                </div>

                <div>
                    <div class="text-gray-500 mb-1">Vật dụng</div>
                    <div class="font-medium text-gray-800" id="vItem"></div>
                </div>

                <div>
                    <div class="text-gray-500 mb-1">Số lượng</div>
                    <div class="font-medium text-gray-800" id="vQty"></div>
                </div>

                <div>
                    <div class="text-gray-500 mb-1">Ngày mượn</div>
                    <div class="font-medium text-gray-800" id="vBorrow"></div>
                </div>

                <div>
                    <div class="text-gray-500 mb-1">Ngày trả</div>
                    <div class="font-medium text-gray-800" id="vReturn"></div>
                </div>
            </div>

            <div>
                <div class="text-gray-500 mb-1">Ghi chú</div>
                <div id="vNote"
                    class="min-h-[60px] rounded-xl border bg-gray-50
                           px-4 py-3 text-gray-700 text-sm">
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-3 px-6 py-4 border-t bg-gray-50">
            <button id="detailEditBtn"
                class="px-5 py-2 rounded-xl bg-yellow-500 hover:bg-yellow-600
                       text-white text-sm font-semibold transition">
                Chỉnh sửa
            </button>

            <button id="closeDetailBtn2"
                class="px-5 py-2 rounded-xl bg-gray-300 hover:bg-gray-400
                       text-gray-800 text-sm font-semibold transition">
                Đóng
            </button>
        </div>

    </div>
</div>

<div id="editModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4">
    <div class="bg-white w-full max-w-3xl rounded-2xl p-6 shadow-xl">
        <h3 id="editTitle" class="text-lg font-bold text-blue-700 mb-4">THÊM GIAO DỊCH</h3>

        <form id="borrowForm" class="grid grid-cols-2 gap-4">
            <input type="hidden" id="transactionId" name="transaction_id">

            <div class="col-span-2 md:col-span-1">
                <label class="text-sm font-medium">Khách hàng</label>
                <select id="user_id" name="user_id" required class="w-full border rounded-lg px-3 py-2">
                    <option value="">-- Chọn khách hàng --</option>
                    @foreach($customers as $c)
                    <option value="{{ $c->id }}">{{ $c->full_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-span-2 md:col-span-1">
                <label class="text-sm font-medium">Vật dụng</label>
                <select id="item_id" name="item_id" required class="w-full border rounded-lg px-3 py-2">
                    <option value="">-- Chọn vật dụng --</option>
                    @foreach($items as $i)
                    <option value="{{ $i->item_id }}" data-available="{{ $i->quantity_available }}">
                        {{ $i->item_name }} (còn {{ $i->quantity_available }})
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="text-sm font-medium">Số lượng</label>
                <input id="quantity" name="quantity" type="number" min="1" required class="w-full border rounded-lg px-3 py-2" placeholder="Số lượng">
            </div>

            <div>
                <label class="text-sm font-medium">Trạng thái</label>
                <select id="status" name="status" class="w-full border rounded-lg px-3 py-2">
                    <option value="borrowed">Chưa trả</option>
                    <option value="returned">Đã trả</option>
                </select>
            </div>

            <div>
                <label class="text-sm font-medium">Ngày mượn</label>
                <input id="borrow_date" name="borrow_date" type="date" required class="w-full border rounded-lg px-3 py-2">
            </div>

            <div>
                <label class="text-sm font-medium">Ngày trả</label>
                <input id="return_date" name="return_date" type="date" class="w-full border rounded-lg px-3 py-2">
            </div>

            <div class="col-span-2">
                <label class="text-sm font-medium">Ghi chú</label>
                <textarea id="note" name="note" rows="4" class="w-full border rounded-lg px-3 py-2" placeholder="Ghi chú..."></textarea>
            </div>

            <div class="col-span-2 flex justify-end gap-3 mt-2">
                <button type="button" id="closeEditBtn" class="px-4 py-2 bg-gray-300 rounded-lg">Hủy</button>
                <button type="submit" id="saveBtn" class="px-4 py-2 bg-green-600 text-white rounded-lg">Lưu thông tin</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const openAddBtn = document.getElementById('openAddBorrowModal');
    const detailModal = document.getElementById('detailModal');
    const editModal = document.getElementById('editModal');
    const closeDetailBtn = document.getElementById('closeDetailBtn');
    const detailEditBtn = document.getElementById('detailEditBtn');
    const editTitle = document.getElementById('editTitle');
    const form = document.getElementById('borrowForm');
    const saveBtn = document.getElementById('saveBtn');
    const csrf = document.querySelector('meta[name="csrf-token"]').content;

    const vId = document.getElementById('vId');
    const vUser = document.getElementById('vUser');
    const vItem = document.getElementById('vItem');
    const vQty = document.getElementById('vQty');
    const vBorrow = document.getElementById('vBorrow');
    const vReturn = document.getElementById('vReturn');
    const vStatus = document.getElementById('vStatus');
    const vNote = document.getElementById('vNote');

    const transactionId = document.getElementById('transactionId');
    const user_id = document.getElementById('user_id');
    const item_id = document.getElementById('item_id');
    const quantity = document.getElementById('quantity');
    const borrow_date = document.getElementById('borrow_date');
    const return_date = document.getElementById('return_date');
    const status = document.getElementById('status');
    const note = document.getElementById('note');

    const open = (el) => el.classList.remove('hidden');
    const close = (el) => el.classList.add('hidden');

    function resetForm() {
        form.reset();
        transactionId.value = '';
        user_id.selectedIndex = 0;
        item_id.selectedIndex = 0;
        status.value = 'borrowed';
    }

    function toInputDate(s) {
        if(!s) return '';
        const d = new Date(s);
        if (isNaN(d)) return '';
        const yyyy = d.getFullYear();
        const mm = String(d.getMonth()+1).padStart(2,'0');
        const dd = String(d.getDate()).padStart(2,'0');
        return `${yyyy}-${mm}-${dd}`;
    }

    document.querySelectorAll('.borrow-row').forEach(row => {
        row.addEventListener('click', (e) => {
            const id = row.dataset.id;
            const user = row.dataset.user;
            const item = row.dataset.item;
            const qty = row.dataset.qty;
            const borrow = row.dataset.borrow;
            const ret = row.dataset.return;
            const st = row.dataset.status;
            const noteText = row.dataset.note || '—';

            vId.textContent = 'MD' + String(id).padStart(4,'0');
            vUser.textContent = user || '—';
            vItem.textContent = item || '—';
            vQty.textContent = qty || '—';
            vBorrow.textContent = borrow ? (new Date(borrow)).toLocaleDateString() : '—';
            vReturn.textContent = ret ? (new Date(ret)).toLocaleDateString() : '—';
            vNote.textContent = noteText;

            if (st === 'returned') {
                vStatus.textContent = 'Đã trả';
                vStatus.className =
                    'inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700';
            } else {
                vStatus.textContent = 'Chưa trả';
                vStatus.className =
                    'inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700';
            }


            detailEditBtn.dataset.rowId = id;
            detailEditBtn.dataset.row = JSON.stringify({
                id,
                user_id: row.dataset.userId,
                item_id: row.dataset.itemId,
                quantity: row.dataset.qty,
                borrow_date: row.dataset.borrow,
                return_date: row.dataset.return,
                status: row.dataset.status,
                note: row.dataset.note
            });

            open(detailModal);
        });
    });

    openAddBtn.addEventListener('click', () => {
        resetForm();
        editTitle.textContent = 'THÊM GIAO DỊCH MƯỢN TRẢ';
        open(editModal);
    });

    closeDetailBtn.addEventListener('click', () => close(detailModal));
    document.getElementById('closeEditBtn').addEventListener('click', () => close(editModal));
    document.getElementById('closeDetailBtn2').onclick = () => close(detailModal);


    detailEditBtn.addEventListener('click', () => {
        const rowData = JSON.parse(detailEditBtn.dataset.row || '{}');
        if (!rowData || !rowData.id) return;

        transactionId.value = rowData.id;
        user_id.value = rowData.user_id || '';
        item_id.value = rowData.item_id || '';
        quantity.value = rowData.quantity || 1;
        borrow_date.value = toInputDate(rowData.borrow_date);
        return_date.value = toInputDate(rowData.return_date);
        status.value = rowData.status || 'borrowed';
        note.value = rowData.note || '';

        editTitle.textContent = 'CHỈNH SỬA GIAO DỊCH';
        close(detailModal);
        open(editModal);
    });

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        saveBtn.disabled = true;
        saveBtn.textContent = 'Đang lưu...';

        const id = transactionId.value;
        const url = id ? `/admin/borrow_return/${id}` : `/admin/borrow_return`;
        const fd = new FormData(form);

        if (id) fd.append('_method', 'PUT');

        try {
            const res = await fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrf,
                    'Accept': 'application/json'
                },
                body: fd
            });

            if (!res.ok) {
                const err = await res.json().catch(()=>null);
                const msg = err?.message || 'Lỗi khi lưu dữ liệu';
                alert(msg);
                saveBtn.disabled = false;
                saveBtn.textContent = 'Lưu thông tin';
                return;
            }

            const data = await res.json().catch(()=>({ok:true}));
            location.reload();

        } catch (error) {
            console.error(error);
            alert('Lỗi kết nối, thử lại');
            saveBtn.disabled = false;
            saveBtn.textContent = 'Lưu thông tin';
        }
    });

    window.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            close(detailModal);
            close(editModal);
        }
    });

    ['detailModal','editModal'].forEach(id => {
        const el = document.getElementById(id);
        if (!el) return;
        el.addEventListener('click', (ev) => {
            if (ev.target === el) {
                close(el);
            }
        });
    });

    item_id.addEventListener('change', () => {
        const opt = item_id.selectedOptions[0];
        const available = opt ? opt.dataset.available : undefined;
        if (available !== undefined) {
            if (available <= 0) {
                alert('Vật dụng này hiện đã hết số lượng sẵn có.');
            }
        }
    });

});
</script>
@endpush
