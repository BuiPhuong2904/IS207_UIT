{{-- resources/views/admin/blogs.blade.php --}}

@extends('layouts.ad_layout')
@section('title', 'Quản lý Blog')
@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js"></script>

<div class="bg-white rounded-2xl shadow-sm p-6 font-open-sans h-full">
    <div class="flex justify-between items-center mb-6">
        <h1 class="font-montserrat text-2xl text-black font-semibold uppercase">BLOGS</h1>
        <button onclick="openModal('addBlogModal')" class="bg-[#28A745] hover:bg-[#218838] text-white px-6 py-2 rounded-full flex items-center font-medium transition-colors shadow-sm hover:shadow-md">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg> Thêm
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse table-auto">
            <thead class="font-montserrat text-[#999] text-xs font-medium uppercase">
            <tr>
                <th class="py-4 px-4">ID</th>
                <th class="py-4 px-4">Tiêu đề</th>
                <th class="py-4 px-4">Tóm tắt</th>
                <th class="py-4 px-4">Danh mục</th>
                <th class="py-4 px-4">Tác giả</th>
                <th class="py-4 px-4 text-center">Thứ tự</th>
                <th class="py-4 px-4">Ngày đăng</th>
                <th class="py-4 px-4 text-right">Trạng thái</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($blogs as $item)
            @php
            $isOdd = $loop->odd;
            $rowBg = $isOdd ? 'bg-[#1976D2]/10' : 'bg-white';

            // Xử lý ngày đăng an toàn (theo đúng Seeder: string hoặc null)
            $publishDate = 'Chưa đăng';
            if ($item->published_at) {
            $publishDate = \Carbon\Carbon::parse($item->published_at)->format('d/m/Y');
            }

            $statusBadge = $item->is_published
            ? '<span class="bg-[#28A745]/20 text-[#28A745] py-1 px-4 rounded-full text-xs font-bold">Đã xuất bản</span>'
            : '<span class="bg-gray-200 text-gray-600 py-1 px-4 rounded-full text-xs font-bold">Bản nháp</span>';

            // Lấy danh mục từ tag đầu tiên (chuỗi ngăn cách bằng dấu phẩy)
            $category = 'Chung';
            if ($item->tags) {
            $firstTag = explode(',', $item->tags)[0] ?? '';
            $category = trim($firstTag) ?: 'Chung';
            }
            @endphp

            <tr class="{{ $rowBg }} cursor-pointer hover:bg-blue-50 transition-colors"
                onclick="openEditModal({{ $item->post_id }})">
                <td class="py-4 px-4 rounded-l-lg">BL{{ str_pad($item->post_id, 4, '0', STR_PAD_LEFT) }}</td>
                <td class="py-4 px-4 font-medium text-gray-800">{{ $item->title }}</td>
                <td class="py-4 px-4 text-gray-600 truncate max-w-xs">{{ Str::limit($item->summary ?? '', 40) }}</td>
                <td class="py-4 px-4">{{ $category }}</td>
                <td class="py-4 px-4">{{ $item->author?->name ?? 'Admin' }}</td>
                <td class="py-4 px-4 text-center">{{ $item->post_id }}</td>
                <td class="py-4 px-4">{{ $publishDate }}</td>
                <td class="py-4 px-4 text-right rounded-r-lg">{!! $statusBadge !!}</td>
            </tr>
            <tr class="h-1 bg-white"></tr>
            @endforeach
            </tbody>
        </table>

        <div class="mt-6 flex justify-center">
            {{ $blogs->links() }}
        </div>
    </div>
</div>

{{-- 2 MODAL THÊM + SỬA giữ nguyên như trước, chỉ sửa JS bên dưới --}}

{{-- ======================== MODAL THÊM MỚI ======================== --}}
<div id="addBlogModal" class="modal-container hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-[90%] md:max-w-6xl h-[90vh] flex flex-col overflow-hidden">
        <div class="flex justify-between items-center px-8 py-5 border-b border-gray-100">
            <h2 class="text-xl font-bold text-[#1976D2] font-montserrat uppercase">VIẾT BÀI MỚI</h2>
            <div class="flex space-x-3">
                <button type="button" onclick="submitAddForm(true)" class="px-6 py-2 bg-[#007bff] hover:bg-blue-600 text-white rounded-lg text-sm font-medium">
                    Lưu nháp
                </button>
                <button type="button" onclick="submitAddForm(false)" class="px-6 py-2 bg-[#28a745] hover:bg-green-600 text-white rounded-lg text-sm font-medium">
                    Xuất bản
                </button>
            </div>
        </div>

        <div class="flex-1 overflow-y-auto custom-scrollbar p-8 bg-[#F8F9FA]">
            <form id="addBlogForm" enctype="multipart/form-data">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    {{-- CỘT TRÁI: Tiêu đề + Nội dung --}}
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-blue-50 p-6 rounded-lg border border-blue-100">
                            <label class="block text-gray-800 font-bold mb-2">
                                Tiêu đề bài viết <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   id="add-title"
                                   name="title"
                                   required
                                   placeholder="Nhập tiêu đề..."
                                   class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 text-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                        </div>

                        <div class="bg-blue-50 p-6 rounded-lg border border-blue-100 flex flex-col h-[600px]">
                            <label class="block text-gray-800 font-bold mb-2">
                                Nội dung bài viết <span class="text-red-500">*</span>
                            </label>
                            <textarea id="editor-add" name="content"></textarea>
                        </div>
                    </div>

                    {{-- CỘT PHẢI: Ảnh, Tóm tắt, Tags, Xuất bản --}}
                    <div class="space-y-6">
                        <!-- Ảnh đại diện -->
                        <div class="bg-blue-50 p-6 rounded-lg border border-blue-100">
                            <label class="block text-gray-800 font-bold mb-4">Ảnh đại diện</label>
                            <input type="file"
                                   name="image"
                                   id="add-file-input"
                                   class="hidden"
                                   accept="image/*"
                                   onchange="previewImage(this,'add-image-preview','add-placeholder')">
                            <div onclick="document.getElementById('add-file-input').click()"
                                 class="border-2 border-dashed border-gray-300 rounded-lg bg-white h-48 flex flex-col items-center justify-center cursor-pointer hover:border-blue-400 group relative overflow-hidden">
                                <div id="add-placeholder" class="flex flex-col items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 group-hover:text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span class="mt-2 text-blue-600 font-medium">Tải ảnh lên</span>
                                    <span class="text-xs text-gray-400 mt-1">PNG, JPG ≤ 5MB</span>
                                </div>
                                <img id="add-image-preview" src="" class="absolute inset-0 w-full h-full object-cover hidden">
                            </div>
                        </div>

                        <!-- Tóm tắt -->
                        <div class="bg-blue-50 p-6 rounded-lg border border-blue-100">
                            <label class="block text-gray-800 font-bold mb-2">Tóm tắt ngắn</label>
                            <textarea id="add-summary"
                                      name="summary"
                                      rows="4"
                                      placeholder="Nhập tóm tắt bài viết..."
                                      class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"></textarea>
                        </div>

                        <!-- Tags -->
                        <div class="bg-blue-50 p-6 rounded-lg border border-blue-100">
                            <label class="block text-gray-800 font-bold mb-2">Tags (ngăn cách bằng dấu phẩy)</label>
                            <input type="text"
                                   id="add-tags"
                                   name="tags"
                                   placeholder="yoga, gym, sức khỏe"
                                   class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                        </div>

                        <!-- Xuất bản ngay -->
                        <div class="bg-blue-50 p-6 rounded-lg border border-blue-100 flex items-center justify-between">
                            <div>
                                <label class="block text-gray-800 font-bold">Xuất bản ngay</label>
                                <p class="text-xs text-gray-400">Bật để bài viết hiển thị công khai</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox"
                                       name="is_published"
                                       value="1"
                                       class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:bg-blue-600 after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
                            </label>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="px-8 py-4 border-t bg-white flex justify-end">
            <button type="button" class="close-modal px-6 py-2 bg-gray-400 hover:bg-gray-500 text-white rounded-lg">
                Hủy
            </button>
        </div>
    </div>
</div>
{{-- ======================== MODAL SỬA ======================== --}}
<div id="editBlogModal" class="modal-container hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-[90%] md:max-w-6xl h-[90vh] flex flex-col overflow-hidden">
        <div class="flex justify-between items-center px-8 py-5 border-b">
            <h2 class="text-xl font-bold text-[#1976D2] font-montserrat uppercase">CHỈNH SỬA BÀI VIẾT</h2>
            <div class="flex space-x-3">
                <button type="button" onclick="submitEditForm(true)" class="px-6 py-2 bg-[#007bff] hover:bg-blue-600 text-white rounded-lg text-sm">Lưu nháp</button>
                <button type="button" onclick="submitEditForm(false)" class="px-6 py-2 bg-[#28a745] hover:bg-green-600 text-white rounded-lg text-sm">Cập nhật & Xuất bản</button>
            </div>
        </div>

        <div class="flex-1 overflow-y-auto custom-scrollbar p-8 bg-[#F8F9FA]">
            <form id="editBlogForm" enctype="multipart/form-data">
                <input type="hidden" id="edit-id">

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-blue-50 p-6 rounded-lg border border-blue-100">
                            <label class="block text-gray-800 font-bold mb-2">Tiêu đề</label>
                            <input type="text" id="edit-title" name="title" required class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 text-lg">
                            <div class="mt-1 text-xs text-gray-400 italic" id="edit-slug">Slug: ...</div>
                        </div>

                        <div class="bg-blue-50 p-6 rounded-lg border border-blue-100 flex flex-col h-[600px]">
                            <label class="block text-gray-800 font-bold mb-2">Nội dung</label>
                            <textarea id="editor-edit" name="content"></textarea>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="bg-blue-50 p-6 rounded-lg border border-blue-100">
                            <label class="block text-gray-800 font-bold mb-4">Ảnh đại diện</label>
                            <input type="file" name="image" id="edit-file-input" class="hidden" accept="image/*"
                                   onchange="previewImage(this,'edit-image-preview','edit-placeholder')">
                            <div onclick="document.getElementById('edit-file-input').click()"
                                 class="border-2 border-dashed border-gray-300 rounded-lg bg-white h-48 flex flex-col items-center justify-center cursor-pointer hover:border-blue-400 group relative overflow-hidden">
                                <div id="edit-placeholder" class="flex flex-col items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 group-hover:text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span class="mt-2 text-blue-600 font-medium">Thay đổi ảnh</span>
                                </div>
                                <img id="edit-image-preview" src="" class="absolute inset-0 w-full h-full object-cover hidden">
                            </div>
                        </div>

                        <div class="bg-blue-50 p-6 rounded-lg border border-blue-100">
                            <label class="block text-gray-800 font-bold mb-2">Tóm tắt</label>
                            <textarea id="edit-summary" name="summary" rows="4" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2"></textarea>
                        </div>

                        <div class="bg-blue-50 p-6 rounded-lg border border-blue-100">
                            <label class="block text-gray-800 font-bold mb-2">Tags (ngăn cách bằng dấu phẩy)</label>
                            <input type="text" id="edit-tags" name="tags" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2">
                        </div>

                        <div class="bg-blue-50 p-6 rounded-lg border border-blue-100 flex items-center justify-between">
                            <div>
                                <label class="block text-gray-800 font-bold">Hiển thị công khai</label>
                                <p class="text-xs text-gray-400">Bật để bài viết xuất hiện trên trang chủ</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="edit-is_published" value="1" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:bg-blue-600 after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
                            </label>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="flex justify-center items-center py-4 border-t bg-white space-x-6">
            <button onclick="deleteBlog()" class="px-8 py-2 bg-[#DC3545] hover:bg-red-700 text-white font-semibold rounded-lg">Xóa</button>
            <button type="button" class="close-modal px-8 py-2 bg-[#C4C4C4] hover:bg-gray-500 text-white font-semibold rounded-lg">Hủy</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    tinymce.init({
        selector: '#editor-add, #editor-edit',
        height: '100%',
        menubar: false,
        plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table help wordcount',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist | link image',
        content_style: 'body { font-family:Open Sans,sans-serif; font-size:14px }'
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
                document.getElementById(imgId).src = e.target.result;
                document.getElementById(imgId).classList.remove('hidden');
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

    // THÊM MỚI – SỬA LỖI 500 HOÀN TOÀN
    function submitAddForm(makeDraft = false) {
        const form = document.getElementById('addBlogForm');
        const formData = new FormData(form);

        // XÓA HẾT các field content cũ (cái rỗng)
        formData.delete('content');

        // Ghi đè lại bằng nội dung thật từ TinyMCE
        const editorContent = tinymce.get('editor-add').getContent();
        if (!editorContent.trim()) {
            alert('Vui lòng nhập nội dung bài viết!');
            return;
        }
        formData.append('content', editorContent);

        // Xử lý is_published đúng 100%
        const isPublished = makeDraft ? false : form.querySelector('input[name="is_published"]').checked;
        formData.set('is_published', isPublished ? '1' : '0'); // dùng set để ghi đè

        fetch('/admin/blogs', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
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
            .catch(err => {
                console.error(err);
                alert('Lỗi hệ thống. Vui lòng thử lại.');
            });
    }

    // SỬA – CŨNG SỬA LỖI
    function submitEditForm(makeDraft = false) {
        const id = document.getElementById('edit-id').value;
        const formData = new FormData(document.getElementById('editBlogForm'));

        formData.delete('content');
        const content = tinymce.get('editor-edit').getContent();
        if (!content.trim()) {
            alert('Nội dung không được để trống!');
            return;
        }
        formData.append('content', content);

        const isPublished = makeDraft ? false : document.getElementById('edit-is_published').checked;
        formData.set('is_published', isPublished ? '1' : '0');
        formData.append('_method', 'PUT');
        fetch(`/admin/blogs/${id}`, {
            method: 'POST',  // đổi từ POST sang PUT
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
            .then(r => r.ok ? r.json() : Promise.reject('Server error'))
            .then(res => {
                alert(res.message || 'Cập nhật thành công!');
                closeModal('editBlogModal');
                location.reload();
            })
            .catch(err => {
                console.error(err);
                alert('Lỗi khi cập nhật bài viết');
            });
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
    .tox-tinymce-aux { z-index: 9999 !important; }
    .custom-scrollbar::-webkit-scrollbar { width: 8px; }
    .custom-scrollbar::-webkit-scrollbar-track { background:#f1f1f1; border-radius:4px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background:#c1c1c1; border-radius:4px; }
</style>
@endpush
