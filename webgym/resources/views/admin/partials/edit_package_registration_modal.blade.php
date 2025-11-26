<div id="edit-package-modal" class="fixed inset-0 z-50 hidden">
    
    <div class="absolute inset-0 bg-black/50 transition-opacity"></div>

    <div class="relative flex min-h-screen items-center justify-center p-4" onclick="toggleModal('edit-package-modal')">
        
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-4xl transform transition-all p-8 relative" onclick="event.stopPropagation()">
            
            <h2 class="text-2xl font-extrabold text-center mb-8 uppercase tracking-wide bg-clip-text text-transparent bg-gradient-to-r from-[#0D47A1] to-[#42A5F5] font-montserrat">
                QUẢN LÝ ĐĂNG KÝ
            </h2>
            
            <h3 class="text-[20px] font-bold text-[#0D47A1] mb-6 font-open-sans">Thông tin giao dịch</h3>

            <form action="" method="POST" class="space-y-6 text-gray-700 font-open-sans">
                @csrf
                @method('PUT')
                
                <!-- ID (disabled) and Package Selection -->
                <div class="flex flex-col md:flex-row gap-6 text-black font-open-sans">
                    
                    <div class="flex items-center flex-1">
                        <label class="w-24 font-medium flex-shrink-0">ID</label>
                        <input 
                            type="text" 
                            id="display_id" 
                            disabled
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none bg-gray-100 text-gray-500 font-semibold cursor-not-allowed"
                        >
                    </div>

                    <!-- Package Selection -->
                    <div class="flex items-center flex-1">
                        <label class="w-20 md:w-auto md:mr-3 font-medium flex-shrink-0">Gói tập</label>
                        
                        <div class="relative flex-1 dropdown-container" id="edit-package-dropdown-container">
                            <input type="hidden" name="package_id" id="edit_selected_package_id">

                            <button type="button" onclick="toggleDropdown('edit-package-options')" class="w-full border border-gray-300 rounded-lg px-4 py-2 flex justify-between items-center bg-white focus:outline-none focus:border-blue-500 transition-colors">
                                <span id="edit-package-display" class="text-[#333333] font-semibold">-- Chọn gói tập --</span>
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>

                            <div id="edit-package-options" class="absolute z-50 mt-1 w-full bg-white border border-gray-200 rounded-lg shadow-xl hidden dropdown-panel">
                                <div class="p-2 border-b border-gray-100">
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none"><svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg></div>
                                        <input type="text" id="edit-package-search" onkeyup="filterEditPackages()" class="w-full bg-gray-100 text-gray-700 rounded-md py-1.5 pl-9 pr-3 text-sm focus:outline-none focus:bg-white focus:ring-1 focus:ring-blue-500 transition-colors" placeholder="Tìm kiếm . . .">
                                    </div>
                                </div>
                                <ul class="max-h-48 overflow-y-auto py-1 text-sm text-gray-700" id="edit-package-list">
                                    @foreach($packages as $pkg)
                                        <li onclick="selectEditPackage('{{ $pkg->id }}', '{{ $pkg->package_name }}')" class="cursor-pointer px-4 py-2 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                                            {{ $pkg->package_name }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User Selection -->
                <div class="flex items-center">
                    <label class="w-24 font-medium flex-shrink-0">Khách hàng</label>
                    
                    <div class="relative flex-1 dropdown-container" id="edit-user-dropdown-container">
                        <input type="hidden" name="user_id" id="edit_selected_user_id">

                        <button type="button" onclick="toggleDropdown('edit-user-options')" class="w-full border border-gray-300 rounded-lg px-4 py-2 flex justify-between items-center bg-white focus:outline-none focus:border-blue-500 transition-colors">
                            <span id="edit-user-display" class="text-[#333333] font-semibold">-- Chọn khách hàng --</span>
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>

                        <div id="edit-user-options" class="absolute z-50 mt-1 w-full bg-white border border-gray-200 rounded-lg shadow-xl hidden dropdown-panel">
                            <div class="p-2 border-b border-gray-100">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none"><svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg></div>
                                    <input type="text" id="edit-user-search" onkeyup="filterEditUsers()" class="w-full bg-gray-100 text-gray-700 rounded-md py-1.5 pl-9 pr-3 text-sm focus:outline-none focus:bg-white focus:ring-1 focus:ring-blue-500 transition-colors" placeholder="Tìm kiếm . . .">
                                </div>
                            </div>
                            <ul class="max-h-48 overflow-y-auto py-1 text-sm text-gray-700" id="edit-user-list">
                                @foreach($users as $user)
                                    @php $formattedUserId = 'KH' . str_pad($user->id, 4, '0', STR_PAD_LEFT); @endphp
                                    <li onclick="selectEditUser('{{ $user->id }}', '{{ $user->full_name }}')" class="cursor-pointer px-4 py-2 hover:bg-blue-50 hover:text-blue-600 transition-colors flex justify-between items-center group">
                                        <span class="text-gray-600 font-mono text-xs group-hover:text-blue-500">{{ $formattedUserId }}</span>
                                        <span class="font-medium text-right">{{ $user->full_name }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Start Date and End Date -->
                <div class="flex flex-col md:flex-row gap-6">
                    <div class="flex items-center flex-1">
                        <label class="w-24 font-medium flex-shrink-0">Từ ngày</label>
                        <input 
                            type="date" 
                            name="start_date" 
                            id="edit_start_date"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500 bg-white text-[#333333] font-semibold"
                        >
                    </div>

                    <div class="flex items-center flex-1">
                        <label class="w-20 md:w-auto md:mr-3 font-medium flex-shrink-0">Đến ngày</label>
                        <input 
                            type="date" 
                            name="end_date" 
                            id="edit_end_date"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500 bg-white text-[#333333] font-semibold"
                        >
                    </div>
                </div>

                <!-- Status Selection -->
                <div class="flex flex-col md:flex-row gap-6">
                    <div class="flex items-center flex-1">
                        <label class="w-24 font-medium flex-shrink-0">Trạng thái</label>
                        <div class="relative flex-1">
                            <select id="edit_status" name="status" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500 bg-white text-[#333333] font-semibold appearance-none">
                                <option value="active">Còn hạn</option>
                                <option value="completed">Hoàn thành</option>
                                <option value="expired">Hết hạn</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-gray-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>
                    <div class="flex-1 hidden md:block"></div>
                </div>

                <div class="flex justify-center space-x-8 pt-6 mt-8">
                    <button type="button" onclick="toggleModal('edit-package-modal')" class="bg-[#C4C4C4] hover:bg-gray-400 text-white font-medium py-2.5 px-10 rounded-lg transition-colors">
                        Hủy
                    </button>
                    <button type="submit" class="bg-[#28A745] hover:bg-[#218838] text-white font-medium py-2.5 px-6 rounded-lg transition-colors">
                        Lưu thông tin
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>