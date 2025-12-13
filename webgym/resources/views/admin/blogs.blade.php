@extends('layouts.ad_layout')

@section('title', 'Quản lý Blog')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">
{{-- Import TinyMCE --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js" referrerpolicy="origin"></script>

<div class="bg-white rounded-2xl shadow-sm p-6 font-open-sans">
    
    {{-- HEADER & BUTTONS --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="font-montserrat text-2xl text-black font-semibold">Quản lý bài viết</h1>
        
        <div class="flex items-center space-x-4">
            {{-- Dropdown lọc --}}
            <div class="flex items-center text-black cursor-pointer hover:text-gray-900">
                <span class="mr-1 text-sm font-medium">Hôm nay</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </div>

            {{-- Nút Thêm --}}
            <button onclick="openModal('addBlogModal')" class="bg-[#28A745] hover:bg-[#218838] text-white px-4 py-2 rounded-full flex items-center text-sm font-semibold transition-colors shadow-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg> 
                Thêm bài viết
            </button>
        </div>
    </div>

    {{-- TABLE CONTENT --}}
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse table-auto font-open-sans">
            <thead class="font-montserrat text-[#1f1d1d] text-sm text-center">
                <tr>
                    <th class="py-4 px-4 w-[5%] truncate">ID</th>
                    <th class="py-4 px-4 w-[25%] text-center truncate">Tiêu đề</th> 
                    <th class="py-4 px-4 w-[15%] truncate">Danh mục</th>
                    <th class="py-4 px-4 w-[15%] truncate">Tác giả</th>
                    <th class="py-4 px-4 w-[15%] truncate">Ngày đăng</th>
                    <th class="py-4 px-4 w-[15%] truncate">Trạng thái</th>
                </tr>
            </thead>
            
            <tbody id="blog-list-body" class="text-sm text-gray-700 text-center">
            @foreach ($blogs as $item)
            @php
                $isOdd = $loop->odd;
                $rowBg = $isOdd ? 'bg-[#1976D2]/20' : 'bg-white';
                $roundLeft = $isOdd ? 'rounded-l-xl' : '';
                $roundRight = $isOdd ? 'rounded-r-xl' : '';

                // Xử lý ngày đăng
                $publishDate = $item->published_at ? \Carbon\Carbon::parse($item->published_at)->format('d/m/Y') : '-';

                // Lấy danh mục
                $category = 'Chung';
                if ($item->tags) {
                    $firstTag = explode(',', $item->tags)[0] ?? '';
                    $category = trim($firstTag) ?: 'Chung';
                }
                
                // Xử lý ảnh (check link ngoài hoặc storage)
                $imgSrc = $item->image_url 
                    ? (\Illuminate\Support\Str::startsWith($item->image_url, 'http') ? $item->image_url : Storage::url($item->image_url)) 
                    : asset('images/no-image.png');
            @endphp

            <tr class="{{ $rowBg }} cursor-pointer transition-colors group h-16"
                onclick="openEditModal({{ $item->post_id }})">
                
                <td class="py-3 px-4 align-middle {{ $roundLeft }} font-medium text-gray-500">
                    #{{ $item->post_id }}
                </td>

                <td class="py-3 px-4 align-middle text-left">
                    <p class="font-semibold text-gray-800 line-clamp-1 transition-colors">{{ $item->title }}</p>
                    <p class="text-xs text-gray-500 line-clamp-1 mt-0.5">{{ Str::limit($item->summary ?? '', 50) }}</p>
                </td>

                <td class="py-3 px-4 align-middle">
                    <span class=" text-gray-700 py-1 px-3 align-middle font-medium">
                        {{ $category }}
                    </span>
                </td>

                <td class="py-3 px-4 align-middle font-medium text-gray-700">
                    {{ $item->author?->full_name ?? 'Admin' }}
                </td>

                <td class="py-3 px-4 align-middle text-gray-600">
                    {{ $publishDate }}
                </td>

                <td class="py-3 px-4 align-middle {{ $roundRight }}">
                    @if (!$item->is_published)
                        {{-- 1. Chưa bật xuất bản --}}
                        <span class="bg-gray-100 text-gray-500 py-1 px-3 rounded-full text-xs font-bold uppercase tracking-wide">
                            Bản nháp
                        </span>
                    @elseif ($item->published_at && \Carbon\Carbon::parse($item->published_at)->isFuture())
                        {{-- 2. Đã bật nhưng ngày > hiện tại --}}
                        <span class="bg-[#0D6EFD]/10 text-[#0D6EFD]/70 py-1 px-3 rounded-full text-xs font-bold uppercase tracking-wide">
                            Đã lên lịch
                        </span>
                    @else
                        {{-- 3. Đã bật và ngày <= hiện tại --}}
                        <span class="bg-[#28A745]/10 text-[#28A745]/90 py-1 px-3 rounded-full text-xs font-bold uppercase tracking-wide">
                            Đã xuất bản
                        </span>
                    @endif
                </td>
            </tr>
            {{-- Spacer row for odd rows visual effect --}}
            <tr class="h-2"></tr>
            @endforeach
            </tbody>
        </table>

        {{-- Phân trang --}}
        @if ($blogs->hasPages())
            <div class="mt-6 flex justify-center">
                {{ $blogs->links() }}
            </div>
        @endif
    </div>
</div>

{{-- MODAL 1: VIẾT BÀI MỚI --}}
<div id="addBlogModal" class="modal-container hidden fixed inset-0 z-50 items-center justify-center bg-black/40 font-open-sans">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-[90%] md:max-w-6xl h-[90vh] flex flex-col overflow-hidden">
        <div class="flex justify-between items-center px-8 py-5 border-b border-gray-100">
            <h2 class="text-xl font-bold text-[#1976D2] font-montserrat uppercase">VIẾT BÀI MỚI</h2>
            <div class="flex space-x-3">
                <button type="button" onclick="submitAddForm(true)" class="px-6 py-2 bg-[#007bff] hover:bg-blue-600 text-white font-medium rounded-lg text-sm transition-colors">Lưu nháp</button>
                <button type="button" onclick="submitAddForm(false)" class="px-6 py-2 bg-[#28a745] hover:bg-green-600 text-white font-medium rounded-lg text-sm transition-colors">Xuất bản</button>
            </div>
        </div>
        <div class="flex-1 overflow-y-auto custom-scrollbar p-8 bg-[#F8F9FA]">
            <form id="addBlogForm" class="grid grid-cols-1 lg:grid-cols-3 gap-8" enctype="multipart/form-data">
                
                {{-- LEFT COLUMN --}}
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-blue-50 p-6 rounded-lg border border-blue-100">
                        <label class="block text-gray-800 font-bold mb-2">Tiêu đề bài viết <span class="text-red-500">*</span></label>
                        <input type="text" id="add-title" name="title" placeholder="Nhập tiêu đề bài viết ở đây . . ." required
                               class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 text-gray-700 outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent text-lg">
                        <div class="mt-1 text-xs text-gray-400 italic">Slug: tu-dong-tao</div>
                    </div>

                    <div class="bg-blue-50 p-6 rounded-lg border border-blue-100 flex flex-col h-[600px]">
                        <label class="block text-gray-800 font-bold mb-2">Nội dung bài viết <span class="text-red-500">*</span></label>
                        <div class="flex-1 rounded-lg overflow-hidden">
                            <textarea id="editor-add" name="content" class="w-full h-full"></textarea>
                        </div>
                    </div>
                </div>

                {{-- RIGHT COLUMN --}}
                <div class="space-y-6">
                    <div class="bg-blue-50 p-6 rounded-lg border border-blue-100">
                        <label class="block text-gray-800 font-bold mb-4">Ảnh đại diện <span class="text-red-500">*</span></label>
                        <input type="file" name="image" id="add-file-input" class="hidden" accept="image/*" onchange="previewImage(this, 'add-image-preview', 'add-placeholder')">
                        <div onclick="document.getElementById('add-file-input').click()" 
                             class="border-2 border-dashed border-gray-300 rounded-lg bg-white h-48 flex flex-col items-center justify-center cursor-pointer hover:border-blue-400 transition-colors group relative overflow-hidden">
                            <div id="add-placeholder" class="flex flex-col items-center">
                                <div class="text-gray-400 group-hover:text-blue-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                </div>
                                <span class="mt-2 text-blue-600 font-medium">Tải ảnh lên</span>
                                <span class="text-xs text-gray-400 mt-1">PNG, JPG, JPEG ≤ 5MB</span>
                            </div>
                            <img id="add-image-preview" src="" class="absolute inset-0 w-full h-full object-cover hidden">
                        </div>
                    </div>
                    <div class="bg-blue-50 p-6 rounded-lg border border-blue-100">
                        <label class="block text-gray-800 font-bold mb-2">Tóm tắt ngắn</label>
                        <textarea id="add-summary" name="summary" rows="4" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2 text-gray-700 outline-none focus:ring-2 focus:ring-blue-400" placeholder="Đoạn văn ngắn hiển thị ngoài trang chủ . . ."></textarea>
                    </div>
                    <div class="bg-blue-50 p-6 rounded-lg border border-blue-100 space-y-4">
                        <div>
                            <label class="block text-gray-800 font-bold mb-1">Tags (ngăn cách bằng dấu phẩy)</label>
                            <input type="text" id="add-tags" name="tags" placeholder="yoga, gym, sức khỏe"
                                   class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2.5 text-gray-700 outline-none focus:ring-2 focus:ring-blue-400">
                        </div>
                        <div class="flex justify-between items-center pt-2">
                            <div>
                                <label class="block text-gray-800 font-bold">Xuất bản ngay</label>
                                <p class="text-xs text-gray-400">Bật để công khai ngay lập tức</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="is_published" value="1" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="flex justify-center items-center py-4 border-t border-gray-100 bg-white">
             <button type="button" class="close-modal w-32 py-2 bg-[#C4C4C4] hover:bg-gray-400 text-white font-semibold rounded-lg transition-colors">Hủy</button>
        </div>
    </div>
</div>

{{-- MODAL 2: SỬA BLOG --}}
<div id="editBlogModal" class="modal-container hidden fixed inset-0 z-50 items-center justify-center bg-black/40 font-open-sans">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-[90%] md:max-w-6xl h-[90vh] flex flex-col overflow-hidden">
        <div class="flex justify-between items-center px-8 py-5 border-b border-gray-100">
            <h2 class="text-xl font-bold text-[#1976D2] font-montserrat uppercase">CHỈNH SỬA BÀI VIẾT</h2>
            <div class="flex space-x-3">
                <button type="button" onclick="submitEditForm(true)" class="px-6 py-2 bg-[#007bff] hover:bg-blue-600 text-white font-medium rounded-lg text-sm transition-colors">Lưu nháp</button>
                <button type="button" onclick="submitEditForm(false)" class="px-6 py-2 bg-[#28a745] hover:bg-green-600 text-white font-medium rounded-lg text-sm transition-colors">Cập nhật & Xuất bản</button>
            </div>
        </div>
        <div class="flex-1 overflow-y-auto custom-scrollbar p-8 bg-[#F8F9FA]">
            <form id="editBlogForm" class="grid grid-cols-1 lg:grid-cols-3 gap-8" enctype="multipart/form-data">
                <input type="hidden" id="edit-id">
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-blue-50 p-6 rounded-lg border border-blue-100">
                        <label class="block text-gray-800 font-bold mb-2">Tiêu đề bài viết <span class="text-red-500">*</span></label>
                        <input type="text" id="edit-title" name="title" required class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 text-gray-700 outline-none focus:ring-2 focus:ring-blue-400 text-lg">
                        <div class="mt-1 text-xs text-gray-400 italic" id="edit-slug">Slug: ...</div>
                    </div>
                    <div class="bg-blue-50 p-6 rounded-lg border border-blue-100 flex flex-col h-[600px]">
                        <label class="block text-gray-800 font-bold mb-2">Nội dung bài viết <span class="text-red-500">*</span></label>
                        <div class="flex-1 rounded-lg overflow-hidden">
                            <textarea id="editor-edit" name="content" class="w-full h-full"></textarea>
                        </div>
                    </div>
                </div>
                <div class="space-y-6">
                    <div class="bg-blue-50 p-6 rounded-lg border border-blue-100">
                        <label class="block text-gray-800 font-bold mb-4">Ảnh đại diện <span class="text-red-500">*</span></label>
                        <input type="file" name="image" id="edit-file-input" class="hidden" accept="image/*" onchange="previewImage(this, 'edit-image-preview', 'edit-placeholder')">
                        <div onclick="document.getElementById('edit-file-input').click()" 
                             class="border-2 border-dashed border-gray-300 rounded-lg bg-white h-48 flex flex-col items-center justify-center cursor-pointer hover:border-blue-400 group relative overflow-hidden">
                            <div id="edit-placeholder" class="flex flex-col items-center z-10">
                                <div class="text-gray-400 group-hover:text-blue-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                </div>
                                <span class="mt-2 text-blue-600 font-medium">Thay đổi ảnh</span>
                            </div>
                            <img src="" id="edit-image-preview" class="absolute inset-0 w-full h-full object-cover hidden">
                        </div>
                    </div>
                    <div class="bg-blue-50 p-6 rounded-lg border border-blue-100">
                        <label class="block text-gray-800 font-bold mb-2">Tóm tắt ngắn</label>
                        <textarea id="edit-summary" name="summary" rows="4" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2 text-gray-700 outline-none focus:ring-2 focus:ring-blue-400"></textarea>
                    </div>
                    <div class="bg-blue-50 p-6 rounded-lg border border-blue-100 space-y-4">
                        <div>
                            <label class="block text-gray-800 font-bold mb-1">Tags</label>
                            <input type="text" id="edit-tags" name="tags" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2.5 text-gray-700 outline-none focus:ring-2 focus:ring-blue-400">
                        </div>
                        <div class="flex justify-between items-center pt-2">
                            <div>
                                <label class="block text-gray-800 font-bold">Hiển thị bài viết</label>
                                <p class="text-xs text-gray-400">Bật để công khai ngay lập tức</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="edit-is_published" name="is_published" value="1" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="flex justify-center items-center py-4 border-t border-gray-100 bg-white space-x-6">
             <button onclick="deleteBlog()" class="px-8 py-2 bg-[#DC3545] hover:bg-red-700 text-white font-semibold rounded-lg transition-colors">Xóa</button>
             <button type="button" class="close-modal px-8 py-2 bg-[#C4C4C4] hover:bg-gray-400 text-white font-semibold rounded-lg transition-colors">Hủy</button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        tinymce.init({
            selector: '#editor-add, #editor-edit', 
            height: '100%',
            menubar: false,
            resize: false,
            plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table code help wordcount',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough forecolor backcolor | link image | alignleft aligncenter alignright alignjustify | bullist numlist',
            content_style: 'body { font-family:Open Sans,sans-serif; font-size:14px }'
        });
    });

    function openModal(id) { document.getElementById(id).classList.replace('hidden', 'flex'); }
    function closeModal(id) { 
        document.getElementById(id).classList.replace('flex', 'hidden'); 
        tinymce.get('editor-add')?.setContent('');
        tinymce.get('editor-edit')?.setContent('');
    }

    document.querySelectorAll('.modal-container').forEach(m => m.addEventListener('click', e => { if (e.target === m) closeModal(m.id); }));
    document.querySelectorAll('.close-modal').forEach(b => b.addEventListener('click', () => closeModal(b.closest('.modal-container').id)));

    function previewImage(input, imgId, placeholderId) {
        if (input.files?.[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                const img = document.getElementById(imgId);
                img.src = e.target.result;
                img.classList.remove('hidden');
                document.getElementById(placeholderId).style.opacity = '0';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function openEditModal(id) {
        fetch(`/admin/blogs/${id}`)
            .then(r => r.json())
            .then(data => {
                document.getElementById('edit-id').value = data.post_id;
                document.getElementById('edit-title').value = data.title;
                document.getElementById('edit-slug').innerText = 'Slug: ' + data.slug;
                document.getElementById('edit-summary').value = data.summary;
                document.getElementById('edit-tags').value = data.tags;
                document.getElementById('edit-is_published').checked = data.is_published;

                tinymce.get('editor-edit').setContent(data.content || '');

                const img = document.getElementById('edit-image-preview');
                const ph = document.getElementById('edit-placeholder');
                if (data.image_url) {
                    img.src = data.image_url;
                    img.classList.remove('hidden');
                    ph.style.opacity = '0';
                } else {
                    img.classList.add('hidden');
                    ph.style.opacity = '1';
                }

                openModal('editBlogModal');
            });
    }

    function submitAddForm(makeDraft = false) {
        const form = document.getElementById('addBlogForm');
        const formData = new FormData(form);
        formData.delete('content');
        const editorContent = tinymce.get('editor-add').getContent();
        if (!editorContent.trim()) { alert('Vui lòng nhập nội dung bài viết!'); return; }
        formData.append('content', editorContent);
        const isPublished = makeDraft ? false : form.querySelector('input[name="is_published"]').checked;
        formData.set('is_published', isPublished ? '1' : '0');

        fetch('/admin/blogs', {
            method: 'POST',
            body: formData,
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
        })
        .then(response => {
            if (!response.ok) throw new Error('Server error');
            return response.json();
        })
        .then(res => {
            alert(res.message || 'Thêm bài viết thành công!');
            closeModal('addBlogModal');
            location.reload();
        })
        .catch(err => { console.error(err); alert('Lỗi hệ thống. Vui lòng thử lại.'); });
    }

    function submitEditForm(makeDraft = false) {
        const id = document.getElementById('edit-id').value;
        const formData = new FormData(document.getElementById('editBlogForm'));
        formData.delete('content');
        const content = tinymce.get('editor-edit').getContent();
        if (!content.trim()) { alert('Nội dung không được để trống!'); return; }
        formData.append('content', content);
        const isPublished = makeDraft ? false : document.getElementById('edit-is_published').checked;
        formData.set('is_published', isPublished ? '1' : '0');
        formData.append('_method', 'PUT');

        fetch(`/admin/blogs/${id}`, {
            method: 'POST',
            body: formData,
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
        })
        .then(r => r.ok ? r.json() : Promise.reject('Server error'))
        .then(res => {
            alert(res.message || 'Cập nhật thành công!');
            closeModal('editBlogModal');
            location.reload();
        })
        .catch(err => { console.error(err); alert('Lỗi khi cập nhật bài viết'); });
    }

    function deleteBlog() {
        if (!confirm('Xóa bài viết này?')) return;
        const id = document.getElementById('edit-id').value;
        fetch(`/admin/blogs/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
        })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                alert(res.message);
                closeModal('editBlogModal');
                location.reload();
            }
        });
    }
</script>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 8px; }
    .custom-scrollbar::-webkit-scrollbar-track { background:#f1f1f1; border-radius:4px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background:#c1c1c1; border-radius:4px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #a8a8a8; }
    .tox-tinymce-aux { z-index: 9999 !important; }
</style>
@endpush