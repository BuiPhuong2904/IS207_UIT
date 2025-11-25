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
                    
                    <div class="relative flex-1 dropdown-container" id="add-class-dropdown-container">
                        
                        <input type="hidden" name="class_id" id="selected_class_id" value="">

                        <button type="button" onclick="toggleDropdown('add-class-options')" class="w-full border border-gray-300 rounded-lg px-4 py-2 flex justify-between items-center bg-white focus:outline-none focus:border-blue-500 transition-colors">
                            <span id="add-class-display-text" class="text-gray-500 font-semibold">-- Chọn tên lớp --</span>
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>

                        <div id="add-class-options" class="absolute z-50 mt-1 w-full bg-white border border-gray-200 rounded-lg shadow-xl hidden dropdown-panel">
                            
                            <div class="p-2 border-b border-gray-100">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </div>
                                    <input type="text" id="add-class-search" onkeyup="filterAddClasses()" class="w-full bg-gray-100 text-gray-700 rounded-md py-1.5 pl-9 pr-3 text-sm focus:outline-none focus:bg-white focus:ring-1 focus:ring-blue-500 transition-colors" placeholder="Tìm kiếm . . .">
                                </div>
                            </div>

                            <ul class="max-h-48 overflow-y-auto py-1 text-sm text-gray-700" id="add-class-list">
                                @foreach($classes_list as $class)
                                    <li onclick="selectAddClass('{{ $class['id'] }}', '{{ $class['name'] }}')" class="class-item cursor-pointer px-4 py-2 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                                        {{ $class['name'] }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>

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
                        
                        <div class="relative flex-1 dropdown-container" id="branch-dropdown-container">                       
                            <input type="hidden" name="branch_id" id="selected_branch_id" value="">
                            
                            <button type="button" onclick="toggleDropdown('branch-options')" class="w-full border border-gray-300 rounded-lg px-4 py-2 flex justify-between items-center bg-white focus:outline-none focus:border-blue-500 transition-colors">
                                <span id="branch-display-text" class="text-gray-500 font-semibold">-- Chọn chi nhánh --</span>
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            
                            <div id="branch-options" class="absolute z-50 mt-1 w-full bg-white border border-gray-200 rounded-lg shadow-lg hidden dropdown-panel">                            
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
                                name="room" 
                                placeholder="Nhập phòng học" 
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500 bg-white text-[#333333] font-semibold"
                            >
                        </div>
                    </div>
                    
                </div>

                <!-- Huấn luyện viên -->
                <div class="flex flex-col md:flex-row gap-6 text-black font-open-sans">
                    
                    <div class="flex items-center flex-1">
                        <label class="w-24 font-medium flex-shrink-0">HLV</label>
                        
                        <div class="relative flex-1 dropdown-container" id="trainer-dropdown-container">
                            <input type="hidden" name="trainer_id" id="selected_trainer_id" value="">

                            <button type="button" onclick="toggleDropdown('trainer-options')" class="w-full border border-gray-300 rounded-lg px-4 py-2 flex justify-between items-center bg-white focus:outline-none focus:border-blue-500 transition-colors">
                                <span id="trainer-display-text" class="text-gray-500 font-semibold">-- Chọn HLV --</span>
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>

                            <div id="trainer-options" class="absolute z-50 mt-1 w-full bg-white border border-gray-200 rounded-lg shadow-xl hidden dropdown-panel">
                                
                                <div class="p-2 border-b border-gray-100">
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                                        </div>
                                        <input type="text" id="trainer-search" onkeyup="filterTrainers()" class="w-full bg-gray-100 text-gray-700 rounded-md py-1.5 pl-9 pr-3 text-sm focus:outline-none focus:bg-white focus:ring-1 focus:ring-blue-500 transition-colors" placeholder="Tìm kiếm . . .">
                                    </div>
                                </div>

                                <ul class="max-h-48 overflow-y-auto py-1 text-sm text-gray-700" id="trainer-list">
                                    @foreach($trainers_list as $trainer)
                                        <li onclick="selectTrainer('{{ $trainer['id'] }}', '{{ $trainer['name'] }}')" class="trainer-item cursor-pointer px-4 py-2 hover:bg-blue-50 hover:text-blue-600 transition-colors flex justify-between">
                                            <span class="text-gray-800">{{ $trainer['id'] }}</span>
                                            <span class="text-gray-500 text-right">{{ $trainer['name'] }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="hidden md:flex items-center flex-1">
                        </div>

                </div>
                
                <!-- Nút Hủy và Thêm thông tin -->
                <div class="flex justify-center space-x-8 pt-6 mt-8">
                    <button type="button" onclick="toggleModal('add-modal')" class="bg-[#C4C4C4] hover:bg-gray-400 text-white font-medium py-2.5 px-10 rounded-lg transition-colors">Hủy</button>
                    <button type="submit" class="bg-[#28A745] hover:bg-[#218838] text-white font-medium py-2.5 px-6 rounded-lg transition-colors">Thêm thông tin</button>
                </div>
            </form>
        </div>
    </div>
</div>