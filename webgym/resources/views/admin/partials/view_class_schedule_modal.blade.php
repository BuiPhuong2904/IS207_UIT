
<!-- Modal Xem danh sách học viên đăng ký lớp -->

<div id="view-modal" class="fixed inset-0 z-50 hidden">
    
    <div class="absolute inset-0 bg-black/50 transition-opacity"></div>

    <div class="relative flex min-h-screen items-center justify-center p-4" onclick="toggleModal('view-modal')">
        
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-3xl transform transition-all p-8 relative" onclick="event.stopPropagation()">
            
            <h2 class="text-2xl font-extrabold text-center mb-8 uppercase tracking-wide bg-clip-text text-transparent bg-gradient-to-r from-[#0D47A1] to-[#42A5F5] font-montserrat">
                DANH SÁCH NGƯỜI ĐĂNG KÝ
            </h2>

            <div class="overflow-hidden">
                <table class="w-full text-left border-collapse font-open-sans">
                    <thead class="text-gray-400 font-normal text-sm text-center">
                        <tr>
                            <th class="py-4 px-4 w-[40%] truncate">Tên</th>
                            <th class="py-4 px-4 w-[30%] truncate">Ngày đăng ký</th>
                            <th class="py-4 px-4 w-[30%] truncate">Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody id="student-list-body" class="text-sm text-gray-700">
                        {{-- Dữ liệu sẽ được JS đổ vào đây --}}
                    </tbody>
                </table>
            </div>

            <div class="flex justify-center mt-8">
                <button type="button" onclick="toggleModal('view-modal')" class="bg-[#C4C4C4] hover:bg-gray-400 text-white font-medium py-2 px-8 rounded-lg transition-colors">
                    Đóng
                </button>
            </div>

        </div>
    </div>
</div>



<script>
    function openViewModal(scheduleId, event) {
        // 1. Chặn sự kiện click lan ra ngoài (để không bị mở nhầm modal Sửa)
        event.stopPropagation();

        // 2. Mở modal (Gọi hàm chung ở file cha)
        toggleModal('view-modal');

        // 3. Tìm danh sách sinh viên tương ứng với ID lịch
        const list = studentLists[scheduleId] || [];
        const tbody = document.getElementById('student-list-body');
        
        // 4. Xóa nội dung cũ
        tbody.innerHTML = '';

        // 5. Tạo dòng mới cho từng học viên
        if (list.length > 0) {
            list.forEach((student, index) => {
                // màu nền xen kẽ
                const isOdd = (index % 2 === 0); 
                const rowBg = isOdd ? 'bg-[#1976D2]/20' : 'bg-white';
                const roundLeft = isOdd ? 'rounded-l-xl' : '';
                const roundRight = isOdd ? 'rounded-r-xl' : '';

                // Badge trạng thái
                let statusBadge = '';

                switch (student.status) {
                    // 1. ATTENDED (Đã tham gia) - Màu Xanh lá
                    case 'attended':
                        statusBadge = `<span class="bg-[#28A745]/10 text-[#28A745]/70 py-1 px-3 rounded-full text-sm font-semibold">Đã tham gia</span>`;
                        break;

                    // 2. REGISTERED (Đã đăng ký) - Màu Xanh dương
                    case 'registered':
                        statusBadge = `<span class="bg-[#1976D2]/10 text-[#1976D2]/70 py-1 px-3 rounded-full text-sm font-semibold">Đã đăng ký</span>`;
                        break;

                    // 3. CANCELLED (Đã hủy) - Màu Đỏ
                    case 'cancelled':
                        statusBadge = `<span class="bg-[#DC3545]/10 text-[#DC3545]/70 py-1 px-3 rounded-full text-sm font-semibold">Đã hủy</span>`;
                        break;

                    // Mặc định (Nếu dữ liệu lỗi hoặc khác) - Màu Xám
                    default:
                        statusBadge = `<span class="bg-gray-200 text-gray-500 py-1 px-3 rounded-full text-xs font-bold">Không xác định</span>`;
                }

                const row = `
                    <tr class="${rowBg}">
                        <td class="py-4 px-4 text-center align-middle ${roundLeft}">${student.name}</td>
                        <td class="py-4 px-4 text-center align-middle">${student.date}</td>
                        <td class="py-4 px-4 text-center align-middle ${roundRight}"> ${statusBadge}
                    </tr>
                    <tr class="h-2"></tr>
                `;
                tbody.innerHTML += row;
            });
        } 
        else {
            tbody.innerHTML = `<tr><td colspan="3" class="py-4 text-center text-gray-500">Chưa có học viên đăng ký</td></tr>`;
        }
    }
</script>