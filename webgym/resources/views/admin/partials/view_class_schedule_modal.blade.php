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