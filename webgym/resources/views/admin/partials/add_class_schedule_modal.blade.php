<!-- Modal Thêm lịch lớp -->

<div id="add-modal" class="fixed inset-0 z-50 hidden">
    
    <div class="absolute inset-0 bg-black/50 transition-opacity"></div>

    <div class="relative flex min-h-screen items-center justify-center p-4" onclick="toggleModal('add-modal')">
        
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-4xl transform transition-all p-8 relative" onclick="event.stopPropagation()">
            
            <h2 class="text-2xl font-extrabold text-center mb-8 uppercase tracking-wide bg-clip-text text-transparent bg-gradient-to-r from-[#0D47A1] to-[#42A5F5] font-montserrat">
                Thêm lịch lớp
            </h2>
            <h3 class="text-[20px] font-bold text-[#0D47A1] mb-6 font-open-sans">Thông tin lịch lớp</h3>

            <!-- Form Thêm lịch lớp -->
            <form action="" method="POST" class="space-y-6 text-gray-700 font-open-sans">
                @csrf
                
                <!-- Tên lớp -->
                <div class="flex items-center text-black font-open-sans">
                    <label class="w-24 font-medium flex-shrink-0">Tên lớp</label>
                    <div class="relative flex-1">
                        <input 
                            type="text" 
                            name="class_name" 
                            placeholder="Nhập tên lớp" 
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500 bg-white text-[#333333] font-semibold"
                        >
                    </div>
                </div>

                <!-- Ngày và Thời gian -->
                <div class="flex flex-col md:flex-row gap-6 text-black font-open-sans">
                    <div class="flex items-center flex-1">
                        <label class="w-24 font-medium flex-shrink-0">Ngày</label>
                        <input 
                            type="date" 
                            id="add_date"
                            name="study_date" 
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500 bg-white text-[#333333] font-semibold"
                        >
                    </div>
                    <div class="flex items-center flex-1 text-black font-open-sans">
                        <label class="w-20 md:w-auto md:mr-3 font-medium flex-shrink-0">Thời gian</label>
                        <div class="flex items-center flex-1">
                            <input 
                                type="time" 
                                name="start_time" 
                                class="w-full border border-gray-300 rounded-lg px-2 py-2 text-center text-[#333333] font-semibold focus:outline-none focus:border-blue-500"
                            />
                            <span class="mx-3 text-gray-700">đến</span>
                            <input 
                                type="time" 
                                name="end_time" 
                                class="w-full border border-gray-300 rounded-lg px-2 py-2 text-center text-[#333333] font-semibold focus:outline-none focus:border-blue-500"
                            />
                        </div>
                    </div>
                </div>

                <!-- Chi nhánh và Phòng học -->
                <div class="flex flex-col md:flex-row gap-6 text-black font-open-sans">

                    <!-- Chi nhánh -->
                    <div class="flex items-center flex-1">
                        <label class="w-24 font-medium text-gray-700 flex-shrink-0">Chi nhánh</label>
                        
                        <div class="relative flex-1" id="branch-dropdown-container">
                            
                            <input type="hidden" name="branch_id" id="selected_branch_id" value="">

                            <button type="button" onclick="toggleDropdown('branch-options')" class="w-full border border-gray-300 rounded-lg px-4 py-2 flex justify-between items-center bg-white focus:outline-none focus:border-blue-500 transition-colors">
                                <span id="branch-display-text" class="text-gray-500 font-semibold">-- Chọn chi nhánh --</span>
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>

                            <div id="branch-options" class="absolute z-5 mt-1 w-full bg-white border border-gray-200 rounded-lg shadow-lg hidden">
                                
                                <div class="p-2 border-b border-gray-100">
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                            </svg>
                                        </div>
                                        <input type="text" id="branch-search" onkeyup="filterBranches()" class="w-full bg-gray-100 text-gray-700 rounded-md py-1.5 pl-9 pr-3 text-sm focus:outline-none focus:bg-white focus:ring-1 focus:ring-blue-500 transition-colors" placeholder="Tìm kiếm . . .">
                                    </div>
                                </div>

                                <ul class="max-h-48 overflow-y-auto py-1 text-sm text-gray-700" id="branch-list">
                                    @foreach($branches_list as $branch)
                                        <li onclick="selectBranch('{{ $branch['id'] }}', '{{ $branch['name'] }}')" class="branch-item cursor-pointer px-4 py-2 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                                            {{ $branch['name'] }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                        </div>
                    </div>

                    <!-- Phòng học -->
                    <div class="flex items-center flex-1 text-black font-open-sans">
                        <label class="w-24 md:w-auto md:mr-4 font-medium flex-shrink-0">Phòng học</label>
                        <div class="relative flex-1">
                            <input 
                                type="text" 
                                name="room_name" 
                                placeholder="Nhập phòng học" 
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500 bg-white text-[#333333] font-semibold"
                            >
                        </div>
                    </div>
                    
                </div>

                <div class="flex justify-center space-x-8 pt-6 mt-8">
                    <button type="button" onclick="toggleModal('add-modal')" class="bg-[#C4C4C4] hover:bg-gray-400 text-white font-medium py-2.5 px-10 rounded-lg transition-colors">Hủy</button>
                    <button type="submit" class="bg-[#28A745] hover:bg-[#218838] text-white font-medium py-2.5 px-6 rounded-lg transition-colors">Thêm thông tin</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Script nằm luôn trong file này để đi kèm với Modal --}}
<script>
    function toggleModal(modalID) {
        const modal = document.getElementById(modalID);
        if(modal) {
            modal.classList.toggle('hidden');
        }
    }

    // 1. Hàm bật/tắt dropdown
    function toggleDropdown(id) {
        const dropdown = document.getElementById(id);
        dropdown.classList.toggle('hidden');
        
        // Focus vào ô tìm kiếm khi mở
        if (!dropdown.classList.contains('hidden')) {
            document.getElementById('branch-search').focus();
        }
    }

    // 2. Hàm chọn giá trị (ĐÃ SỬA THEO YÊU CẦU CỦA BẠN)
    function selectBranch(id, name) {
        // Cập nhật input ẩn (để gửi form)
        document.getElementById('selected_branch_id').value = id;
        
        // Cập nhật text hiển thị trên nút
        const display = document.getElementById('branch-display-text');
        display.innerText = name;
        
        // Xử lý đổi màu và độ đậm nhạt
        if(id) {
            // Nếu đã chọn: Xóa màu xám, Thêm màu #333333 và in đậm
            display.classList.remove('text-gray-500');
            display.classList.add('text-[#333333]', 'font-semibold');
        } else {
            // Nếu chưa chọn (hoặc reset): Về lại màu xám, bỏ in đậm
            display.classList.add('text-gray-500');
            display.classList.remove('text-[#333333]', 'font-semibold');
        }

        // Đóng dropdown
        document.getElementById('branch-options').classList.add('hidden');
    }

    // 3. Hàm lọc (Search)
    function filterBranches() {
        const input = document.getElementById('branch-search');
        const filter = input.value.toLowerCase();
        const ul = document.getElementById('branch-list');
        const li = ul.getElementsByTagName('li');

        // Duyệt qua từng dòng li để ẩn/hiện
        for (let i = 0; i < li.length; i++) {
            const txtValue = li[i].textContent || li[i].innerText;
            if (txtValue.toLowerCase().indexOf(filter) > -1) {
                li[i].style.display = "";
            } else {
                li[i].style.display = "none";
            }
        }
    }

    // 4. Đóng dropdown khi click ra ngoài
    window.addEventListener('click', function(e) {
        const container = document.getElementById('branch-dropdown-container');
        if (!container.contains(e.target)) {
            document.getElementById('branch-options').classList.add('hidden');
        }
    });   
</script>