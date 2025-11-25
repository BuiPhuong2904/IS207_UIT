

<div id="edit-modal" class="fixed inset-0 z-50 hidden">
    
    <div class="absolute inset-0 bg-black/50 transition-opacity"></div>

    <div class="relative flex min-h-screen items-center justify-center p-4" onclick="toggleModal('edit-modal')">
        
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-4xl transform transition-all p-8 relative" onclick="event.stopPropagation()">
            
            <h2 class="text-2xl font-extrabold text-center mb-8 uppercase tracking-wide bg-clip-text text-transparent bg-gradient-to-r from-[#0D47A1] to-[#42A5F5] font-montserrat">
                Quản lý lịch lớp
            </h2>
            <h3 class="text-[20px] font-bold text-[#0D47A1] mb-6 font-open-sans">Thông tin lịch lớp</h3>

            <form action="" method="POST" class="space-y-6 text-gray-700 font-open-sans">
                @csrf
                @method('PUT') {{-- Giả lập phương thức PUT cho update --}}
                
                <div class="flex flex-col md:flex-row gap-6 text-black">
                    
                    <!-- ID Lớp học (Chỉ đọc) -->
                    <div class="flex items-center flex-1">
                        <label class="w-24 font-medium flex-shrink-0">ID</label>
                        <input 
                            type="text" 
                            id="edit_id" 
                            name="id" 
                            value="LL0001" 
                            readonly
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none bg-gray-100 text-gray-500 font-semibold cursor-not-allowed"
                        >
                    </div>

                    <!-- Tên lớp học -->
                    <div class="flex items-center flex-1">
                        <label class="w-20 md:w-auto md:mr-3 font-medium flex-shrink-0">Tên lớp</label>
                        <div class="relative flex-1">
                            <input 
                                type="text" 
                                id="edit_class_name"
                                name="class_name" 
                                placeholder="Nhập tên lớp" 
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500 bg-white text-[#333333] font-semibold"
                            >
                        </div>
                    </div>

                </div>

                <div class="flex flex-col md:flex-row gap-6 text-black font-open-sans">

                    <!-- Ngày học -->
                    <div class="flex items-center flex-1">
                        <label class="w-24 font-medium flex-shrink-0">Ngày</label>
                        <input 
                            type="date" 
                            id="edit_date"
                            name="study_date" 
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500 bg-white text-[#333333] font-semibold"
                        >
                    </div>

                    <!-- Thời gian học -->
                    <div class="flex items-center flex-1">
                        <label class="w-20 md:w-auto md:mr-3 font-medium flex-shrink-0">Thời gian</label>
                        <div class="flex items-center flex-1">
                            <input 
                                type="time" 
                                id="edit_start_time" 
                                name="start_time" 
                                class="time-picker w-full border border-gray-300 rounded-lg px-2 py-2 text-center text-[#333333] font-semibold focus:outline-none focus:border-blue-500"
                            >
                            
                            <span class="mx-3 text-gray-700">đến</span>
                            
                            <input 
                                type="time" 
                                id="edit_end_time" 
                                name="end_time" 
                                class="time-picker w-full border border-gray-300 rounded-lg px-2 py-2 text-center text-[#333333] font-semibold focus:outline-none focus:border-blue-500"
                            >
                        </div>
                    </div>

                </div>

                <div class="flex flex-col md:flex-row gap-6 text-black font-open-sans">

                    <!-- Chi nhánh -->
                    <div class="flex items-center flex-1 relative">
                        <label class="w-24 font-medium text-gray-700 flex-shrink-0">Chi nhánh</label>
                        
                        <div class="relative flex-1" id="edit-branch-dropdown-container">
                            
                            <input type="hidden" name="branch_id" id="edit_selected_branch_id" value="">

                            <button type="button" onclick="toggleDropdown('edit-branch-options')" class="w-full border border-gray-300 rounded-lg px-4 py-2 flex justify-between items-center bg-white focus:outline-none focus:border-blue-500 transition-colors">
                                <span id="edit-branch-display-text" class="text-[#333333] font-semibold">-- Chọn chi nhánh --</span>
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>

                            <div id="edit-branch-options" class="absolute z-50 mt-1 w-full bg-white border border-gray-200 rounded-lg shadow-xl hidden">
                                
                                <div class="p-2 border-b border-gray-100">
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                            </svg>
                                        </div>
                                        <input type="text" id="edit-branch-search" onkeyup="filterEditBranches()" class="w-full bg-gray-100 text-gray-700 rounded-md py-1.5 pl-9 pr-3 text-sm focus:outline-none focus:bg-white focus:ring-1 focus:ring-blue-500 transition-colors" placeholder="Tìm kiếm . . .">
                                    </div>
                                </div>

                                <ul class="max-h-48 overflow-y-auto py-1 text-sm text-gray-700" id="edit-branch-list">
                                    @foreach($branches_list as $branch)
                                        <li onclick="selectEditBranch('{{ $branch['id'] }}', '{{ $branch['name'] }}')" class="branch-item cursor-pointer px-4 py-2 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                                            {{ $branch['name'] }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                        </div>
                    </div>

                    <!-- Phòng học -->
                    <div class="flex items-center flex-1">
                        <label class="w-20 md:w-auto md:mr-4 font-medium flex-shrink-0">Phòng học</label>
                        <div class="relative flex-1">
                            <input 
                                type="text" 
                                id="edit_room"
                                name="room_name" 
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500 bg-white text-[#333333] font-semibold"
                            >
                        </div>
                    </div>

                </div>

                <!-- Trạng thái -->
                <div class="flex flex-col md:flex-row gap-6 text-black font-open-sans">
                    <div class="flex items-center w-full md:w-1/2 pr-3"> <label class="w-24 font-medium text-gray-700 flex-shrink-0">Trạng thái</label>
                        <div class="relative flex-1">
                            <select id="edit_status" name="status" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500 bg-white text-[#333333] font-semibold appearance-none">
                                <option value="completed">Đã hoàn thành</option>
                                <option value="scheduled">Đã lên lịch</option>
                                <option value="cancelled">Đã hủy</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-gray-500"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg></div>
                        </div>
                    </div>

                </div>

                <!-- Nút hành động -->
                <div class="flex justify-center space-x-8 pt-6 mt-8">
                    <button type="button" onclick="toggleModal('edit-modal')" class="bg-[#C4C4C4] hover:bg-gray-400 text-white font-medium py-2.5 px-10 rounded-lg transition-colors">Hủy</button>
                    <button type="submit" class="bg-[#28A745] hover:bg-[#218838] text-white font-medium py-2.5 px-6 rounded-lg transition-colors">Lưu thông tin</button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    // --- 1. Hàm Toggle Modal chung (Giữ nguyên) ---
    function toggleModal(modalID) {
        const modal = document.getElementById(modalID);
        if(modal) {
            modal.classList.toggle('hidden');
        }
    }

    // --- 2. Hàm Mở Modal Sửa và Đổ dữ liệu (ĐÃ CẬP NHẬT LOGIC MỚI) ---
    function openEditModal(data) {
        // Mở modal edit
        toggleModal('edit-modal');

        // --- Đổ dữ liệu cơ bản ---
        if(document.getElementById('edit_id')) 
            document.getElementById('edit_id').value = data.id;
        
        if(document.getElementById('edit_class_name')) 
            document.getElementById('edit_class_name').value = data.class_code;

        if(document.getElementById('edit_room')) 
            document.getElementById('edit_room').value = data.room;
        
        if(document.getElementById('edit_status')) 
            document.getElementById('edit_status').value = data.status;

        // --- XỬ LÝ NGÀY (Format data: mm/dd/yyyy -> Input cần: yyyy-mm-dd) ---
        // --- XỬ LÝ NGÀY (LOGIC: NGÀY/THÁNG/NĂM) ---
        let dateInput = document.getElementById('edit_date');
        
        if (dateInput) {
            // Reset
            dateInput.value = '';

            if (data.date && data.date.includes('/')) {
                let parts = data.date.split('/'); 
                
                let day   = parts[0].trim();
                let month = parts[1].trim();
                let year  = parts[2].trim();

                // Input HTML5 chỉ ăn định dạng: YYYY-MM-DD
                // ghép: Năm - Tháng - Ngày
                let isoDate = `${year}-${month}-${day}`;
                
                // Trình duyệt sẽ nhận giá trị này và tự hiển thị cho user thấy là "11/07/2025"
                
                console.log("Ngày convert để gán vào input:", isoDate);
                dateInput.value = isoDate;
            }
            else {
                dateInput.value = data.date;
            }
        }

        // --- XỬ LÝ GIỜ (Format data: "07:00 AM - 09:00 AM" -> Input cần: "07:00", "09:00") ---
        if(data.time && data.time.includes('-')) {
            // 1. Tách chuỗi: Dùng ' - ' (khoảng trắng gạch khoảng trắng)
            // Nếu dữ liệu không có khoảng trắng thì fallback về '-'
            let separator = data.time.includes(' - ') ? ' - ' : '-';
            let times = data.time.split(separator); 

            // Hàm phụ: Chuyển "01:30 PM" -> "13:30"
            const convertTo24h = (timeStr) => {
                // Tạo ngày giả định để JS tự parse giờ
                let date = new Date("1/1/2000 " + timeStr);
                let h = date.getHours().toString().padStart(2, '0');
                let m = date.getMinutes().toString().padStart(2, '0');
                return `${h}:${m}`;
            };

            if(times.length >= 2) {
                if(document.getElementById('edit_start_time')) 
                    document.getElementById('edit_start_time').value = convertTo24h(times[0]);
                
                if(document.getElementById('edit_end_time')) 
                    document.getElementById('edit_end_time').value = convertTo24h(times[1]);
            }
        }

        // --- Xử lý Dropdown Chi nhánh (Custom Dropdown) ---
        if(document.getElementById('edit_selected_branch_id'))
            document.getElementById('edit_selected_branch_id').value = data.branch;
        
        if(document.getElementById('edit-branch-display-text')) {
            document.getElementById('edit-branch-display-text').innerText = data.branch;
            document.getElementById('edit-branch-display-text').classList.remove('text-gray-500');
            document.getElementById('edit-branch-display-text').classList.add('text-[#333333]', 'font-semibold');
        }
    }

    // --- 3. Xử lý chọn Chi nhánh trong Modal Sửa ---
    function selectEditBranch(id, name) {
        document.getElementById('edit_selected_branch_id').value = id;
        
        const display = document.getElementById('edit-branch-display-text');
        display.innerText = name;
        
        // Update style
        display.classList.remove('text-gray-500');
        display.classList.add('text-[#333333]', 'font-semibold');

        // Ẩn dropdown
        const options = document.getElementById('edit-branch-options');
        if(options) options.classList.add('hidden');
    }

    // Hàm tìm kiếm trong dropdown Sửa (MỚI THÊM)
    function filterEditBranches() {
        const input = document.getElementById('edit-branch-search');
        const filter = input.value.toLowerCase();
        const ul = document.getElementById('edit-branch-list');
        const li = ul.getElementsByTagName('li');

        for (let i = 0; i < li.length; i++) {
            const txtValue = li[i].textContent || li[i].innerText;
            if (txtValue.toLowerCase().indexOf(filter) > -1) {
                li[i].style.display = "";
            } else {
                li[i].style.display = "none";
            }
        }
    }

    // --- 4. Xử lý toggle dropdown trong Modal Sửa ---
    function toggleDropdown(id) {
        const el = document.getElementById(id);
        if(el) el.classList.toggle('hidden');
    }

</script>