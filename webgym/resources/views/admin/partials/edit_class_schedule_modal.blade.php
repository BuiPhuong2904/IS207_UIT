

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
                        
                        <div class="relative flex-1 dropdown-container" id="edit-class-dropdown-container">
                            
                            <input type="hidden" name="class_id" id="edit_selected_class_id" value="">

                            <button type="button" onclick="toggleDropdown('edit-class-options')" class="w-full border border-gray-300 rounded-lg px-4 py-2 flex justify-between items-center bg-white focus:outline-none focus:border-blue-500 transition-colors">
                                <span id="edit-class-display-text" class="text-[#333333] font-semibold">-- Chọn tên lớp --</span>
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>

                            <div id="edit-class-options" class="absolute z-50 mt-1 w-full bg-white border border-gray-200 rounded-lg shadow-xl hidden dropdown-panel">
                                
                                <div class="p-2 border-b border-gray-100">
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                            </svg>
                                        </div>
                                        <input type="text" id="edit-class-search" onkeyup="filterEditClasses()" class="w-full bg-gray-100 text-gray-700 rounded-md py-1.5 pl-9 pr-3 text-sm focus:outline-none focus:bg-white focus:ring-1 focus:ring-blue-500 transition-colors" placeholder="Tìm kiếm . . .">
                                    </div>
                                </div>

                                <ul class="max-h-48 overflow-y-auto py-1 text-sm text-gray-700" id="edit-class-list">
                                    @foreach($classes_list as $class)
                                        <li onclick="selectEditClass('{{ $class['id'] }}', '{{ $class['name'] }}')" class="class-item cursor-pointer px-4 py-2 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                                            {{ $class['name'] }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

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
                        
                        <div class="relative flex-1 dropdown-container" id="edit-branch-dropdown-container">
                            
                            <input type="hidden" name="branch_id" id="edit_selected_branch_id" value="">

                            <button type="button" onclick="toggleDropdown('edit-branch-options')" class="w-full border border-gray-300 rounded-lg px-4 py-2 flex justify-between items-center bg-white focus:outline-none focus:border-blue-500 transition-colors">
                                <span id="edit-branch-display-text" class="text-[#333333] font-semibold">-- Chọn chi nhánh --</span>
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>

                            <div id="edit-branch-options" class="absolute z-50 mt-1 w-full bg-white border border-gray-200 rounded-lg shadow-xl hidden dropdown-panel">
                                
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

                <!-- HLV và Trạng thái -->
                <div class="flex flex-col md:flex-row gap-6 text-black font-open-sans">
                
                    <!-- HLV -->
                    <div class="flex items-center flex-1 relative">
                        <label class="w-24 font-medium flex-shrink-0">HLV</label>
                        
                        <div class="relative flex-1 dropdown-container" id="edit-trainer-dropdown-container">
                            <input type="hidden" name="trainer_id" id="edit_selected_trainer_id" value="">
                            
                            <button type="button" onclick="toggleDropdown('edit-trainer-options')" class="w-full border border-gray-300 rounded-lg px-4 py-2 flex justify-between items-center bg-white focus:outline-none focus:border-blue-500 transition-colors">
                                <span id="edit-trainer-display-text" class="text-[#333333] font-semibold">-- Chọn HLV --</span>
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            
                            <div id="edit-trainer-options" class="absolute z-50 mt-1 w-full bg-white border border-gray-200 rounded-lg shadow-xl hidden dropdown-panel">
                                <div class="p-2 border-b border-gray-100">
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none"><svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg></div>
                                        <input type="text" id="edit-trainer-search" onkeyup="filterEditTrainers()" class="w-full bg-gray-100 text-gray-700 rounded-md py-1.5 pl-9 pr-3 text-sm focus:outline-none focus:bg-white focus:ring-1 focus:ring-blue-500 transition-colors" placeholder="Tìm kiếm . . .">
                                    </div>
                                </div>
                                <ul class="max-h-48 overflow-y-auto py-1 text-sm text-gray-700" id="edit-trainer-list">
                                    @foreach($trainers_list as $trainer)
                                        <li onclick="selectEditTrainer('{{ $trainer['id'] }}', '{{ $trainer['name'] }}')" class="trainer-item cursor-pointer px-4 py-2 hover:bg-blue-50 hover:text-blue-600 transition-colors flex justify-between">
                                            <span class="text-gray-800 font-medium">{{ $trainer['id'] }}</span>
                                            <span class="text-gray-500 text-right">{{ $trainer['name'] }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Trạng thái -->
                    <div class="flex items-center flex-1">
                        <label class="w-20 md:w-auto md:mr-4 font-medium flex-shrink-0">Trạng thái</label>
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
    // --- LOGIC ĐẶC THÙ: MỞ MODAL SỬA ---
    function openEditModal(data) {
        ScheduleApp.toggleModal('edit-modal');

        // 1. Đổ dữ liệu input cơ bản
        const setVal = (id, val) => { 
            if(document.getElementById(id)) document.getElementById(id).value = val; 
        };
        
        setVal('edit_id', data.id);
        setVal('edit_room', data.room);
        
        // --- Xử lý Dropdown Status ---
        if(document.getElementById('edit_status')) {
             document.getElementById('edit_status').value = data.status;
             
             // Logic cập nhật text status
             let statusText = 'Chọn trạng thái';
             if(data.status === 'completed') statusText = 'Đã hoàn thành';
             else if(data.status === 'scheduled') statusText = 'Đã lên lịch';
             else if(data.status === 'cancelled') statusText = 'Đã hủy';
             
             if(document.getElementById('status-display-text')) 
                document.getElementById('status-display-text').innerText = statusText;
        }

        // --- Tái sử dụng hàm selectItem để hiển thị dữ liệu đã chọn ---
        
        // Lớp học
        ScheduleApp.selectItem({
            inputId: 'edit_selected_class_id',
            displayId: 'edit-class-display-text',
            value: data.class_code, // hoặc data.class_id
            text: data.class_name || data.class_code
        });

        // Chi nhánh
        ScheduleApp.selectItem({
            inputId: 'edit_selected_branch_id',
            displayId: 'edit-branch-display-text',
            value: data.branch,
            text: data.branch
        });

        // HLV
        ScheduleApp.selectItem({
            inputId: 'edit_selected_trainer_id',
            displayId: 'edit-trainer-display-text',
            value: data.trainer_id,
            text: data.trainer_name || '-- Chọn HLV --',
            isReset: !data.trainer_name // Nếu ko có tên thì hiện màu xám
        });

        // --- Xử lý Ngày (Convert dd/mm/yyyy -> yyyy-mm-dd) ---
        if(document.getElementById('edit_date')) {
             if(data.date && data.date.includes('/')) {
                let parts = data.date.split('/'); 
                document.getElementById('edit_date').value = `${parts[2]}-${parts[0]}-${parts[1]}`;
             } else {
                document.getElementById('edit_date').value = data.date;
             }
        }
        
        // --- Xử lý Giờ (AM/PM -> 24h) ---
        if(data.time && data.time.includes('-')) {
            // 1. Tách chuỗi: Dùng ' - ' (khoảng trắng gạch khoảng trắng)
            // Nếu dữ liệu không có khoảng trắng thì fallback về '-'
            let separator = data.time.includes(' - ') ? ' - ' : '-';
            let times = data.time.split(separator);

            // Hàm chuyển đổi giờ AM/PM sang 24h
            const convertTo24h = (timeStr) => {
                // Tạo ngày giả định để JS tự parse giờ
                let date = new Date("1/1/2000 " + timeStr);
                if (isNaN(date.getTime())) return ""; // Kiểm tra lỗi nếu format sai
                
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
    }

    // --- CÁC HÀM CHỌN CHO FORM SỬA (Wrapper) ---
    function selectEditClass(id, name) {
        ScheduleApp.selectItem({
            inputId: 'edit_selected_class_id',
            displayId: 'edit-class-display-text',
            dropdownId: 'edit-class-options',
            value: id, text: name
        });
    }
    
    function selectEditBranch(id, name) {
        ScheduleApp.selectItem({
            inputId: 'edit_selected_branch_id',
            displayId: 'edit-branch-display-text',
            dropdownId: 'edit-branch-options',
            value: id, text: name
        });
    }

    function selectEditTrainer(id, name) {
        ScheduleApp.selectItem({
            inputId: 'edit_selected_trainer_id',
            displayId: 'edit-trainer-display-text',
            dropdownId: 'edit-trainer-options',
            value: id, text: name
        });
    }

    // --- CÁC HÀM LỌC CHO FORM SỬA (Wrapper) ---
    function filterEditClasses() { ScheduleApp.filterList('edit-class-search', 'edit-class-list'); }
    function filterEditBranches() { ScheduleApp.filterList('edit-branch-search', 'edit-branch-list'); }
    function filterEditTrainers() { ScheduleApp.filterList('edit-trainer-search', 'edit-trainer-list'); }

</script>