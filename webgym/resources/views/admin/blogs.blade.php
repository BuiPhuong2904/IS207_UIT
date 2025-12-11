@extends('layouts.ad_layout')

@section('title', 'Quản lý Blog')

@section('content')

{{-- KHỐI TẠO DỮ LIỆU GIẢ (MOCK DATA) --}}
@php
    $blogs = [
        (object)[
            'id' => 'BL0001',
            'title' => 'Gói tháng',
            'slug' => 'goi-thang',
            'summary' => 'Khám phá những lợi ích tuyệt vời của gói tập theo tháng...',
            'content' => '<p>Nội dung chi tiết <strong>gói tháng</strong>...</p>',
            'category' => 'Yoga',
            'author' => 'Nguyễn Văn A',
            'order' => 1,
            'publish_date' => '2025-11-07',
            'status' => 'published',
            'image' => '', 
            'tags' => 'gym, yoga',
            'is_public' => true
        ],
        (object)[
            'id' => 'BL0002',
            'title' => 'Gói quý',
            'slug' => 'goi-quy',
            'summary' => 'Khám phá ưu đãi đặc biệt khi đăng ký gói quý...',
            'content' => 'Nội dung chi tiết bài viết gói quý...',
            'category' => 'Cardio',
            'author' => 'Nguyễn Văn B',
            'order' => 2,
            'publish_date' => '2025-11-07',
            'status' => 'draft',
            'image' => '',
            'tags' => 'cardio, health',
            'is_public' => false
        ],
        (object)[
            'id' => 'BL0003',
            'title' => 'Gói năm',
            'slug' => 'goi-nam',
            'summary' => 'Cam kết dài lâu cùng sức khỏe với gói tập năm...',
            'content' => 'Nội dung chi tiết bài viết gói năm...',
            'category' => 'Yoga',
            'author' => 'Nguyễn Văn C',
            'order' => 3,
            'publish_date' => '2025-11-07',
            'status' => 'published',
            'image' => '',
            'tags' => 'yoga, life',
            'is_public' => true
        ],
    ];
@endphp

<meta name="csrf-token" content="{{ csrf_token() }}">

{{-- IMPORT TINYMCE (TRÌNH SOẠN THẢO) --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js" referrerpolicy="origin"></script>

<div class="bg-white rounded-2xl shadow-sm p-6 font-open-sans h-full">
    
    {{-- HEADER & BUTTONS --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="font-montserrat text-2xl text-black font-semibold uppercase">BLOGS</h1>
        
        <div class="flex items-center space-x-4">
            
            {{-- Dropdown lọc --}}
            <div class="flex items-center text-black cursor-pointer hover:text-gray-900 bg-white border border-gray-200 px-3 py-1.5 rounded-lg shadow-sm">
                <span class="mr-1 text-sm font-medium">Hôm nay</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </div>

            {{-- Nút Thêm --}}
            <button onclick="openModal('addBlogModal')" class="bg-[#28A745] hover:bg-[#218838] text-white px-6 py-2 rounded-full flex items-center font-medium transition-colors shadow-sm cursor-pointer hover:shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Thêm
            </button>
        </div>
    </div>

    {{-- TABLE CONTENT --}}
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse table-auto">
            
            <thead class="font-montserrat text-[#999] text-xs font-medium uppercase">
                <tr>
                    <th class="py-4 px-4 w-[10%]">ID</th>
                    <th class="py-4 px-4 w-[15%]">Tiêu đề</th>
                    <th class="py-4 px-4 w-[20%]">Tóm tắt</th>
                    <th class="py-4 px-4 w-[10%]">Danh mục</th>
                    <th class="py-4 px-4 w-[15%]">Tên tác giả</th>
                    <th class="py-4 px-4 w-[5%] text-center">Thứ tự</th>
                    <th class="py-4 px-4 w-[10%]">Thời điểm</th>
                    <th class="py-4 px-4 w-[15%] text-right">Trạng thái</th>
                </tr>
            </thead>

            <tbody id="blog-list-body" class="text-sm text-gray-700">
                @foreach ($blogs as $item)
                    @php
                        $isOdd = $loop->odd;
                        $rowBg = $isOdd ? 'bg-[#1976D2]/10' : 'bg-white'; 
                        
                        $publishDate = \Carbon\Carbon::parse($item->publish_date)->format('T6/d/m/Y');
                        
                        $statusBadge = $item->status === 'published'
                            ? '<span class="bg-[#28A745]/20 text-[#28A745] py-1 px-4 rounded-full text-xs font-bold">Đã xuất bản</span>'
                            : '<span class="bg-gray-200 text-gray-600 py-1 px-4 rounded-full text-xs font-bold">Bản nháp</span>';
                    @endphp

                    <tr class="{{ $rowBg }} cursor-pointer transition-colors modal-trigger hover:bg-blue-50"
                        onclick="openEditModal('{{ json_encode($item) }}')"
                    >
                        {{-- ID --}}
                        <td class="py-4 px-4 align-middle rounded-l-lg">{{ $item->id }}</td>
                        {{-- Tiêu đề --}}
                        <td class="py-4 px-4 align-middle font-medium text-gray-800">{{ $item->title }}</td>
                        {{-- Tóm tắt --}}
                        <td class="py-4 px-4 align-middle text-gray-600 truncate max-w-xs">{{ Str::limit($item->summary, 40) }}</td>
                        {{-- Danh mục --}}
                        <td class="py-4 px-4 align-middle">{{ $item->category }}</td>
                        {{-- Tác giả --}}
                        <td class="py-4 px-4 align-middle">{{ $item->author }}</td>
                        {{-- Thứ tự --}}
                        <td class="py-4 px-4 align-middle text-center">{{ $item->order }}</td>
                        {{-- Thời điểm --}}
                        <td class="py-4 px-4 align-middle">{{ $publishDate }}</td>
                        {{-- Trạng thái --}}
                        <td class="py-4 px-4 align-middle text-right rounded-r-lg">{!! $statusBadge !!}</td>
                    </tr>
                    
                    <tr class="h-1 bg-white"></tr> 
                @endforeach
            </tbody>
        </table>

        {{-- Pagination (Placeholder) --}}
        <div class="mt-6 flex justify-end items-center space-x-2">
           {{-- Logic phân trang nếu cần --}}
        </div>
    </div>
</div>

{{-- ==================================================================================== --}}
{{-- MODAL 1: VIẾT BÀI MỚI (ADD NEW) --}}
{{-- ==================================================================================== --}}
<div id="addBlogModal" class="modal-container hidden fixed inset-0 z-50 items-center justify-center bg-black/40 font-open-sans backdrop-blur-sm">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-[90%] md:max-w-6xl h-[90vh] flex flex-col overflow-hidden">
        
        {{-- Modal Header --}}
        <div class="flex justify-between items-center px-8 py-5 border-b border-gray-100">
            <h2 class="text-xl font-bold text-[#1976D2] font-montserrat uppercase">VIẾT BÀI MỚI</h2>
            <div class="flex space-x-3">
                <button class="px-6 py-2 bg-[#007bff] hover:bg-blue-600 text-white font-medium rounded-lg text-sm transition-colors">Lưu nháp</button>
                <button onclick="submitAddForm()" class="px-6 py-2 bg-[#28a745] hover:bg-green-600 text-white font-medium rounded-lg text-sm transition-colors">Xuất bản</button>
            </div>
        </div>

        {{-- Modal Body (Scrollable) --}}
        <div class="flex-1 overflow-y-auto custom-scrollbar p-8 bg-[#F8F9FA]">
            {{-- Thêm enctype để upload file --}}
            <form id="addBlogForm" class="grid grid-cols-1 lg:grid-cols-3 gap-8" enctype="multipart/form-data">
                
                {{-- LEFT COLUMN (Main Content) --}}
                <div class="lg:col-span-2 space-y-6">
                    {{-- Tiêu đề --}}
                    <div class="bg-blue-50 p-6 rounded-lg border border-blue-100">
                        <label class="block text-gray-800 font-bold mb-2">Tiêu đề bài viết <span class="text-red-500">*</span></label>
                        <input type="text" name="title" placeholder="Nhập tiêu đề bài viết ở đây . . ." 
                               class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 text-gray-700 outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent text-lg">
                        <div class="mt-1 text-xs text-gray-400 italic">Slug: tu-tao-o-day</div>
                    </div>

                    {{-- Nội dung (Đã thay bằng TinyMCE) --}}
                    <div class="bg-blue-50 p-6 rounded-lg border border-blue-100 flex flex-col h-[600px]">
                        <label class="block text-gray-800 font-bold mb-2">Nội dung bài viết <span class="text-red-500">*</span></label>
                        <div class="flex-1 rounded-lg overflow-hidden">
                            {{-- Textarea này sẽ biến thành Editor --}}
                            <textarea id="editor-add" name="content" class="w-full h-full"></textarea>
                        </div>
                    </div>
                </div>

                {{-- RIGHT COLUMN (Settings) --}}
                <div class="space-y-6">
                    {{-- Ảnh đại diện (Đã sửa logic Upload) --}}
                    <div class="bg-blue-50 p-6 rounded-lg border border-blue-100">
                        <label class="block text-gray-800 font-bold mb-4">Ảnh đại diện <span class="text-red-500">*</span></label>
                        
                        {{-- Input file ẩn --}}
                        <input type="file" name="image" id="add-file-input" class="hidden" accept="image/*" onchange="previewImage(this, 'add-image-preview', 'add-placeholder')">
                        
                        {{-- Click vào div này để kích hoạt input file --}}
                        <div onclick="document.getElementById('add-file-input').click()" 
                             class="border-2 border-dashed border-gray-300 rounded-lg bg-white h-48 flex flex-col items-center justify-center cursor-pointer hover:border-blue-400 transition-colors group relative overflow-hidden">
                            
                            {{-- Placeholder --}}
                            <div id="add-placeholder" class="flex flex-col items-center">
                                <div class="text-gray-400 group-hover:text-blue-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <span class="mt-2 text-blue-600 font-medium">Tải ảnh lên</span>
                                <span class="text-xs text-gray-400 mt-1">PNG, JPG, JPEG lên tới 5 MB</span>
                            </div>

                            {{-- Image Preview --}}
                            <img id="add-image-preview" src="" class="absolute inset-0 w-full h-full object-cover hidden">
                        </div>
                    </div>

                    {{-- Tóm tắt ngắn --}}
                    <div class="bg-blue-50 p-6 rounded-lg border border-blue-100">
                        <label class="block text-gray-800 font-bold mb-2">Tóm tắt ngắn</label>
                        <textarea name="summary" rows="4" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2 text-gray-700 outline-none focus:ring-2 focus:ring-blue-400" placeholder="Đoạn văn ngắn hiển thị ngoài trang chủ . . ."></textarea>
                    </div>

                    {{-- Cài đặt khác --}}
                    <div class="bg-blue-50 p-6 rounded-lg border border-blue-100 space-y-4">
                        {{-- Tags --}}
                        <div>
                            <label class="block text-gray-800 font-bold mb-1">Tags <span class="text-red-500">*</span></label>
                            <select name="tags" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2.5 text-gray-700 outline-none focus:ring-2 focus:ring-blue-400">
                                <option value="">Chọn tag ở đây . . .</option>
                                <option value="yoga">Yoga</option>
                                <option value="gym">Gym</option>
                            </select>
                        </div>

                        {{-- Ngày đăng --}}
                        <div>
                            <label class="block text-gray-800 font-bold mb-1">Ngày đăng <span class="text-red-500">*</span></label>
                            <input type="date" name="publish_date" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2.5 text-gray-700 outline-none focus:ring-2 focus:ring-blue-400">
                        </div>

                        {{-- Hiển thị bài viết --}}
                        <div class="flex justify-between items-center pt-2">
                            <div>
                                <label class="block text-gray-800 font-bold">Hiển thị bài viết</label>
                                <p class="text-xs text-gray-400">Bật để công khai ngay lập tức</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="is_public" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        {{-- Modal Footer --}}
        <div class="flex justify-center items-center py-4 border-t border-gray-100 bg-white">
             <button type="button" class="close-modal w-32 py-2 bg-[#C4C4C4] hover:bg-gray-400 text-white font-semibold rounded-lg transition-colors">Hủy</button>
        </div>
    </div>
</div>

{{-- ==================================================================================== --}}
{{-- MODAL 2: QUẢN LÝ BLOG --}}
{{-- ==================================================================================== --}}
<div id="editBlogModal" class="modal-container hidden fixed inset-0 z-50 items-center justify-center bg-black/40 font-open-sans backdrop-blur-sm">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-[90%] md:max-w-6xl h-[90vh] flex flex-col overflow-hidden">
        
        {{-- Modal Header --}}
        <div class="flex justify-between items-center px-8 py-5 border-b border-gray-100">
            <h2 class="text-xl font-bold text-[#1976D2] font-montserrat uppercase">BÀI BLOG</h2>
            <div class="flex space-x-3">
                <button class="px-6 py-2 bg-[#007bff] hover:bg-blue-600 text-white font-medium rounded-lg text-sm transition-colors">Lưu nháp</button>
                <button onclick="submitEditForm()" class="px-6 py-2 bg-[#28a745] hover:bg-green-600 text-white font-medium rounded-lg text-sm transition-colors">Xuất bản</button>
            </div>
        </div>

        {{-- Modal Body (Scrollable) --}}
        <div class="flex-1 overflow-y-auto custom-scrollbar p-8 bg-[#F8F9FA]">
            <form id="editBlogForm" class="grid grid-cols-1 lg:grid-cols-3 gap-8" enctype="multipart/form-data">
                <input type="hidden" id="edit-id" name="id">

                {{-- LEFT COLUMN --}}
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-blue-50 p-6 rounded-lg border border-blue-100">
                        <label class="block text-gray-800 font-bold mb-2">Tiêu đề bài viết <span class="text-red-500">*</span></label>
                        <input type="text" id="edit-title" name="title"
                               class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 text-gray-700 outline-none focus:ring-2 focus:ring-blue-400 text-lg">
                        <div class="mt-1 text-xs text-gray-400 italic" id="edit-slug">Slug: ...</div>
                    </div>

                    {{-- Nội dung Edit --}}
                    <div class="bg-blue-50 p-6 rounded-lg border border-blue-100 flex flex-col h-[600px]">
                        <label class="block text-gray-800 font-bold mb-2">Nội dung bài viết <span class="text-red-500">*</span></label>
                        <div class="flex-1 rounded-lg overflow-hidden">
                            <textarea id="editor-edit" name="content" class="w-full h-full"></textarea>
                        </div>
                    </div>
                </div>

                {{-- RIGHT COLUMN --}}
                <div class="space-y-6">
                    {{-- Ảnh đại diện Edit --}}
                    <div class="bg-blue-50 p-6 rounded-lg border border-blue-100">
                        <label class="block text-gray-800 font-bold mb-4">Ảnh đại diện <span class="text-red-500">*</span></label>
                        
                        <input type="file" name="image" id="edit-file-input" class="hidden" accept="image/*" onchange="previewImage(this, 'edit-image-preview', 'edit-placeholder')">

                        <div onclick="document.getElementById('edit-file-input').click()" 
                             class="border-2 border-dashed border-gray-300 rounded-lg bg-white h-48 flex flex-col items-center justify-center cursor-pointer hover:border-blue-400 group relative overflow-hidden">
                            
                            <div id="edit-placeholder" class="flex flex-col items-center z-10">
                                <div class="text-gray-400 group-hover:text-blue-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <span class="mt-2 text-blue-600 font-medium">Thay đổi ảnh</span>
                            </div>
                            
                            {{-- Image Preview --}}
                            <img src="" id="edit-image-preview" class="absolute inset-0 w-full h-full object-cover hidden">
                        </div>
                    </div>

                    <div class="bg-blue-50 p-6 rounded-lg border border-blue-100">
                        <label class="block text-gray-800 font-bold mb-2">Tóm tắt ngắn</label>
                        <textarea id="edit-summary" name="summary" rows="4" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2 text-gray-700 outline-none focus:ring-2 focus:ring-blue-400"></textarea>
                    </div>

                    <div class="bg-blue-50 p-6 rounded-lg border border-blue-100 space-y-4">
                        <div>
                            <label class="block text-gray-800 font-bold mb-1">Tags <span class="text-red-500">*</span></label>
                            <select id="edit-tags" name="tags" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2.5 text-gray-700 outline-none focus:ring-2 focus:ring-blue-400">
                                <option value="yoga">Yoga</option>
                                <option value="gym">Gym</option>
                                <option value="cardio">Cardio</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-800 font-bold mb-1">Ngày đăng <span class="text-red-500">*</span></label>
                            <input type="date" id="edit-publish_date" name="publish_date" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2.5 text-gray-700 outline-none focus:ring-2 focus:ring-blue-400">
                        </div>
                        <div class="flex justify-between items-center pt-2">
                            <div>
                                <label class="block text-gray-800 font-bold">Hiển thị bài viết</label>
                                <p class="text-xs text-gray-400">Bật để công khai ngay lập tức</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="edit-is_public" name="is_public" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        {{-- Modal Footer --}}
        <div class="flex justify-center items-center py-4 border-t border-gray-100 bg-white space-x-6">
             <button onclick="deleteBlog()" class="px-8 py-2 bg-[#DC3545] hover:bg-red-700 text-white font-semibold rounded-lg transition-colors">Xóa</button>
             <button type="button" class="close-modal px-8 py-2 bg-[#C4C4C4] hover:bg-gray-400 text-white font-semibold rounded-lg transition-colors">Hủy</button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // --- 0. CẤU HÌNH EDITOR (TINYMCE) ---
    // Khởi tạo editor khi trang load xong
    document.addEventListener('DOMContentLoaded', function() {
        tinymce.init({
            selector: '#editor-add, #editor-edit', // Áp dụng cho cả 2 modal
            height: '100%',
            menubar: false, // Ẩn menu bar mặc định cho gọn
            resize: false, // Không cho kéo giãn thủ công (để giữ layout)
            plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table code help wordcount',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough forecolor backcolor | link image | alignleft aligncenter alignright alignjustify | bullist numlist',
            content_style: 'body { font-family:Open Sans,sans-serif; font-size:14px }'
        });
    });

    // --- 1. HELPERS ---
    function closeModal(id) { 
        const m = document.getElementById(id);
        m.classList.add('hidden'); 
        m.classList.remove('flex'); 
    }
    
    function openModal(id) { 
        const m = document.getElementById(id);
        m.classList.remove('hidden'); 
        m.classList.add('flex'); 
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.close-modal').forEach(b => b.addEventListener('click', () => {
            closeModal(b.closest('.modal-container').id);
        }));

        document.querySelectorAll('.modal-container').forEach(m => m.addEventListener('click', e => {
            if (e.target === m) closeModal(m.id);
        }));
    });

    // --- 2. LOGIC PREVIEW ẢNH ---
    function previewImage(input, imgId, placeholderId) {
        const file = input.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById(imgId);
                const placeholder = document.getElementById(placeholderId);
                
                img.src = e.target.result;
                img.classList.remove('hidden'); // Hiện ảnh
                placeholder.style.opacity = '0'; // Ẩn chữ hướng dẫn (nhưng giữ layout)
            }
            reader.readAsDataURL(file);
        }
    }

    // --- 3. LOGIC EDIT ---
    function openEditModal(dataString) {
        const data = JSON.parse(dataString);
        
        document.getElementById('edit-id').value = data.id;
        document.getElementById('edit-title').value = data.title;
        document.getElementById('edit-slug').innerText = 'Slug: ' + data.slug;
        document.getElementById('edit-summary').value = data.summary;
        document.getElementById('edit-publish_date').value = data.publish_date;
        document.getElementById('edit-is_public').checked = data.is_public;

        // Set nội dung vào Editor
        if (tinymce.get('editor-edit')) {
            tinymce.get('editor-edit').setContent(data.content);
        }

        // Xử lý ảnh cũ (Placeholder logic)
        const img = document.getElementById('edit-image-preview');
        const placeholder = document.getElementById('edit-placeholder');
        if(data.image) {
            img.src = data.image; // Trong thực tế là path/to/image
            img.classList.remove('hidden');
            placeholder.style.opacity = '0';
        } else {
            img.classList.add('hidden');
            placeholder.style.opacity = '1';
        }

        openModal('editBlogModal');
    }

    // --- 4. SUBMIT FORM (Mô phỏng) ---
    function submitAddForm() {
        // Lấy nội dung từ editor
        const content = tinymce.get('editor-add').getContent();
        alert('Đã thêm bài viết mới!\nNội dung editor: ' + content.substring(0, 50) + '...');
        closeModal('addBlogModal');
    }

    function submitEditForm() {
        const id = document.getElementById('edit-id').value;
        const content = tinymce.get('editor-edit').getContent();
        alert('Đã cập nhật bài ' + id + '!\nNội dung editor: ' + content.substring(0, 50) + '...');
        closeModal('editBlogModal');
    }

    function deleteBlog() {
        const id = document.getElementById('edit-id').value;
        if(confirm('Bạn có chắc chắn muốn xóa bài viết này không?')) {
            alert('Đã xóa bài viết ' + id);
            closeModal('editBlogModal');
        }
    }

</script>
<style>
    /* Custom Scrollbar */
    .custom-scrollbar::-webkit-scrollbar { width: 8px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 4px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #c1c1c1; border-radius: 4px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #a8a8a8; }
    
    /* Fix z-index của TinyMCE để không bị che bởi Modal */
    .tox-tinymce-aux {
        z-index: 9999 !important;
    }
</style>
@endpush
