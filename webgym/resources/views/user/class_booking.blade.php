@extends('user.layouts.user_layout')

@section('title', 'GRYND - Đặt lịch ' . $gymClass->class_name)

@section('content')

<div class="bg-white max-w-full mx-auto px-4 sm:px-6 lg:px-8 py-10 font-open-sans">
    
    <div class="text-center mb-8">
        <h1 class="font-montserrat font-extrabold text-[64px] bg-gradient-to-r from-[#0D47A1] to-[#42A5F5] text-transparent bg-clip-text uppercase">
            Chọn lịch tập cho lớp học
        </h1>
        <p class="font-roboto font-semibold text-[18px] text-[#1976D2] mt-2">
            Vui lòng chọn ngày và giờ tập phù hợp với bạn
        </p>
    </div>

    @csrf
    <div class="bg-[#F5F7FA] rounded-[20px] shadow-sm border border-slate-100 p-6 md:p-8">
        
        <!-- Tiêu đề và bộ lọc chi nhánh -->
        <div class="font-open-sans flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <h2 class="font-montserrat text-[28px] font-bold text-[#0D47A1]">{{ $gymClass->class_name }} hiện hoạt</h2>
            
            <div class="relative w-72 font-sans" id="dropdown-soft">
        
                <!-- Nút bấm hiển thị chi nhánh đang chọn -->
                <button onclick="toggleSoft()" 
                        class="w-full bg-white text-black border-1 border-[#1976D2] rounded-[10px] py-2.5 px-5 transition-all duration-200 flex items-center justify-between hover:shadow-md">
                    <span id="label-soft" class="truncate">{{ $selectedBranch ?? 'Chọn chi nhánh' }}</span>
                    <svg id="arrow-soft" class="w-5 h-5 ml-2 text-slate-500 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <!-- Menu xổ xuống (Được tạo động từ PHP) -->
                <div id="menu-soft" class="absolute z-50 w-full mt-2 bg-white rounded-2xl shadow-[0_10px_40px_-10px_rgba(0,0,0,0.15)] overflow-hidden hidden animate-fade-in-down origin-top">
                    <ul class="text-sm font-medium max-h-[300px] overflow-y-auto">
                        @if($allBranches->isEmpty())
                            <li class="px-5 py-3 text-gray-500 text-center">
                                Chưa có lịch tại bất kỳ chi nhánh nào.
                            </li>
                        @else
                            @foreach($allBranches as $branch)
                                @php
                                    $isSelected = $branch === $selectedBranch;
                                    $style = $isSelected ? 'bg-blue-50 text-blue-600' : 'hover:bg-blue-50 hover:text-blue-600';
                                @endphp
                                <li onclick="selectBranch('{{ $branch }}')" 
                                    class="px-5 py-3 cursor-pointer transition-colors border-b border-gray-50 last:border-0 {{ $style }}">
                                    {{ $branch }}
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </div>

        <!-- Lịch học -->
        <div class="relative w-full font-open-sans">
            
            <div class="flex items-center gap-2">
                
                <button id="btn-prev" onclick="scrollSchedule('left')" 
                        class="flex xl:hidden items-center justify-center w-8 h-8 rounded-full bg-blue-200 text-white hover:bg-blue-300 transition shrink-0 z-10 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                    </svg>
                </button>

                <div id="schedule-container" 
                    class="flex-1 flex gap-4 overflow-x-auto scroll-smooth snap-x no-scrollbar xl:grid xl:grid-cols-7 xl:overflow-visible">
                    
                    @foreach($weekDays as $dayLabel)
                        @php
                            $schedulesForDay = $groupedSchedules[$dayLabel] ?? collect();
                            $hasData = $schedulesForDay->isNotEmpty();
                        @endphp

                        <div class="snap-start shrink-0 min-w-[260px] xl:min-w-0 xl:w-auto bg-white rounded-[20px] border-2 border-[#1976D2] overflow-hidden flex flex-col h-full min-h-[220px] shadow-lg transition-all hover:shadow-xl">
                            
                            {{-- Tiêu đề ngày --}}
                            <div class="text-center py-3 font-extrabold text-black border-b border-[#1976D2]">
                                {{ $dayLabel }}
                            </div>

                            {{-- Nội dung --}}
                            @if($hasData)
                                <div class="p-3 flex flex-col gap-3 h-full justify-center">
                                    @foreach($schedulesForDay as $schedule)
                                        
                                        <div onclick="toggleSelect(this)" 
                                            data-id="{{ $schedule->id }}"
                                            data-day="{{ $dayLabel }}" 
                                            data-time="{{ $schedule->start_time }} - {{ $schedule->end_time }}" 
                                            data-trainer="{{ $schedule->trainer_name }}" 

                                            class="schedule-card bg-white border border-[#5E9FE0] shadow-sm rounded-[20px] p-2 text-center cursor-pointer transition duration-200 hover:shadow-md transform hover:-translate-y-0.5 select-none">
                                            
                                            <div class="text-sm font-extrabold text-black pointer-events-none">
                                                {{ $schedule->start_time }} - {{ $schedule->end_time }}
                                            </div>
                                            <div class="text-xs font-semibold text-[#333333]/70 mt-1 pointer-events-none">
                                                {{ $schedule->trainer_name }}
                                            </div>

                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="p-3 flex items-center justify-center h-full">
                                    <span class="text-sm font-semibold text-[#333333]/60 select-none">
                                        Không có lớp
                                    </span>
                                </div>
                            @endif

                        </div>
                    @endforeach

                </div>

                <button id="btn-next" onclick="scrollSchedule('right')" 
                        class="flex xl:hidden items-center justify-center w-8 h-8 rounded-full bg-blue-200 text-white hover:bg-blue-300 transition shrink-0 z-10 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                    </svg>
                </button>
            </div>
        </div>
        
        <!-- Xác nhận đăng ký -->
        <div class="mt-8 pt-6 border-t border-gray-300 text-center font-open-sans">
            
            {{-- Mặc định hiển thị khi chưa chọn gì --}}
            <div id="no-selection-msg" class="text-gray-500 italic">
                Vui lòng chọn ít nhất một lịch học ở trên.
            </div>

            {{-- Hiển thị khi đã chọn --}}
            <div id="selection-info" class="hidden">
                <p class="text-gray-700 text-sm md:text-base leading-relaxed">
                    Bạn đã chọn: <br>
                    <span id="selected-times" class="font-bold text-blue-800 text-lg block my-2"></span>
                    
                    tại <span class="font-bold text-[#1976D2]">{{ $selectedBranch }}</span>
                </p>

                <div class="mt-6">
                    <button id="confirm-btn" onclick="submitRegistration()" class="bg-[#1976D2] rounded-[10px] hover:bg-blue-700 text-white text-[18px] font-bold py-3 px-8 shadow-md transition duration-300 ease-in-out transform hover:-translate-y-1">
                        Xác nhận đăng ký
                    </button>
                </div>
            </div>

        </div>

    </div>
</div>

<style>
    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-down {
        animation: fadeInDown 0.2s ease-out forwards;
    }

    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }
    .no-scrollbar {
        -ms-overflow-style: none;  /* IE and Edge */
        scrollbar-width: none;  /* Firefox */
    }
</style>

<script>

    // 1. XỬ LÝ DROPDOWN (CHỌN CHI NHÁNH)
    function selectBranch(val) {
        const url = new URL(window.location.href);
        url.searchParams.set('branch', val);
        window.location.href = url.toString();
    }

    const menuSoft = document.getElementById('menu-soft');
    const arrowSoft = document.getElementById('arrow-soft');
    let isSoftOpen = false;

    function toggleSoft() {
        isSoftOpen = !isSoftOpen;
        if (isSoftOpen) {
            menuSoft.classList.remove('hidden');
            arrowSoft.classList.add('rotate-180');
        } else {
            menuSoft.classList.add('hidden');
            arrowSoft.classList.remove('rotate-180');
        }
    }

    window.addEventListener('click', function(e){
        const dropdown = document.getElementById('dropdown-soft');
        if (!dropdown.contains(e.target)){
            isSoftOpen = false;
            menuSoft.classList.add('hidden');
            arrowSoft.classList.remove('rotate-180');
        }
    });


    // 2. XỬ LÝ CUỘN LỊCH (SCROLL SCHEDULE)
    function scrollSchedule(direction) {
        const container = document.getElementById('schedule-container');
        
        const item = container.firstElementChild;
        const gap = 16; 
        const scrollAmount = item ? (item.offsetWidth + gap) : 300;

        const maxScrollLeft = container.scrollWidth - container.clientWidth;
        const currentScroll = container.scrollLeft;

        if (direction === 'right') {
            if (currentScroll >= maxScrollLeft - 10) {
                container.scrollTo({ left: 0, behavior: 'smooth' });
            } else {
                container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
            }
        } else {
            if (currentScroll <= 10) {
                container.scrollTo({ left: maxScrollLeft, behavior: 'smooth' });
            } else {
                container.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
            }
        }
    }

    // 3. XỬ LÝ CHỌN LỊCH HỌC (SELECTION & SORTING)

    // Định nghĩa thứ tự ưu tiên cho các ngày
    const dayOrder = {
        "Thứ 2": 2, "Thứ 3": 3, "Thứ 4": 4, 
        "Thứ 5": 5, "Thứ 6": 6, "Thứ 7": 7, "Chủ Nhật": 8
    };

    let selectedSchedules = [];

    function toggleSelect(element) {
        // A. Lấy dữ liệu
        const id = element.getAttribute('data-id');
        const day = element.getAttribute('data-day');
        const time = element.getAttribute('data-time');
        const trainer = element.getAttribute('data-trainer');
        
        // Tách giờ bắt đầu để sắp xếp (VD: "08:00")
        const startTime = time.split(' - ')[0].trim(); 
        
        const uniqueId = `${day}_${time}_${trainer}`;

        // B. Kiểm tra chọn/bỏ chọn
        const index = selectedSchedules.findIndex(item => item.id == id);

        if (index > -1) {
            // BỎ CHỌN
            selectedSchedules.splice(index, 1);            
            element.classList.remove('bg-[#BAD6F2]', 'border-[#5E9FE0]', 'shadow-lg', 'scale-105');
            element.classList.add('bg-white', 'border-[#5E9FE0]');

        } else {
            selectedSchedules.push({ id: id, day, time, startTime, trainer });            
            element.classList.remove('bg-white', 'border-[#5E9FE0]');
            element.classList.add('bg-[#BAD6F2]', 'border-[#5E9FE0]', 'text-black', 'shadow-lg', 'scale-105');
        }

        updateSelectionUI();
    }

    function updateSelectionUI() {
        const noMsg = document.getElementById('no-selection-msg');
        const infoDiv = document.getElementById('selection-info');
        const textSpan = document.getElementById('selected-times');

        if (selectedSchedules.length === 0) {
            noMsg.classList.remove('hidden');
            infoDiv.classList.add('hidden');
        } else {
            noMsg.classList.add('hidden');
            infoDiv.classList.remove('hidden');

            // --- SẮP XẾP DANH SÁCH ---
            selectedSchedules.sort((a, b) => {
                // 1. So sánh theo Thứ
                const dayDiff = dayOrder[a.day] - dayOrder[b.day];
                if (dayDiff !== 0) return dayDiff;

                // 2. Nếu cùng Thứ, so sánh theo Giờ bắt đầu
                return a.startTime.localeCompare(b.startTime);
            });

            // --- RENDER HTML ---
            const html = selectedSchedules.map(item => {
                return `<div class="mb-2 pb-2 border-b border-gray-100 last:border-0 last:pb-0 last:mb-0">
                            <span class="font-bold text-gray-800">${item.day}</span> 
                            <span class="text-sm text-gray-500">(${item.time})</span> 
                            <span class="font-normal text-black"> với 
                            <span class="font-bold text-[#1976D2]">${item.trainer}</span>
                        </div>`;
            }).join('');

            textSpan.innerHTML = html;
        }
    }

    function submitRegistration() {
        if (selectedSchedules.length === 0) return;

        // Lấy danh sách ID
        const scheduleIds = selectedSchedules.map(item => item.id);
        const token = document.querySelector('input[name="_token"]').value;

        // Gọi về Server
        fetch("{{ route('user.class.booking.store') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify({
                schedule_ids: scheduleIds
            })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                alert("Đăng ký thành công!");
                location.reload();
            } else {
                alert("Lỗi: " + data.message);
                // Reset lại nút bấm nếu có lỗi
                btn.innerText = originalText;
                btn.disabled = false;
                btn.classList.remove('opacity-70', 'cursor-not-allowed');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert("Có lỗi xảy ra, vui lòng thử lại.");
        });
    }
</script>

@endsection