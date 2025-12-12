<div id="order-detail-modal" class="fixed inset-0 z-50 hidden font-open-sans">
    <div class="absolute inset-0 bg-black/50 transition-opacity"></div>
    <div class="relative flex min-h-screen items-center justify-center p-4" onclick="toggleModal('order-detail-modal')">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl transform transition-all relative flex flex-col max-h-[90vh] overflow-hidden" onclick="event.stopPropagation()">
            
            {{-- HEADER --}}
            <div class="flex-none pt-6 pb-2 px-8">
                <h2 class="text-2xl font-bold text-center uppercase text-[#1976D2]">Quản lý đơn hàng</h2>
            </div>

            <form id="update-order-form" action="" method="POST" class="flex flex-col flex-1 overflow-hidden">
                @csrf
                @method('PUT')
                {{-- BODY --}}
                <div class="flex-1 overflow-y-auto custom-scrollbar p-8 pt-4 space-y-6">
                    
                    {{-- SECTION 1: THÔNG TIN CHUNG --}}
                    <div>
                        <h3 class="text-lg font-bold text-[#0D47A1] mb-3">Thông tin chung</h3>
                        <div class="space-y-3 pl-1">
                            <div class="flex items-center">
                                <label class="w-24 text-gray-800 font-medium text-sm">Mã đơn hàng</label>
                                <input type="text" id="modal-order-code" readonly
                                    class="flex-1 px-4 py-1.5 bg-[#D9D9D94D] border border-[#99999980] rounded-xl text-[#333333] font-medium focus:outline-none">
                            </div>
                            <div class="flex items-center">
                                <label class="w-24 text-gray-800 font-medium text-sm">Ngày đặt</label>
                                <input type="text" id="modal-date" readonly 
                                    class="flex-1 px-4 py-1.5 bg-[#D9D9D94D] border border-[#99999980] rounded-xl text-[#333333] font-medium focus:outline-none">
                            </div>
                            <div class="flex items-center">
                                <label class="w-24 text-gray-800 font-medium text-sm">Mã giảm giá</label>
                                <input type="text" id="modal-coupon" readonly
                                    class="flex-1 px-4 py-1.5 bg-[#D9D9D94D] border border-[#99999980] rounded-xl text-[#333333] font-medium focus:outline-none">
                            </div>
                        </div>
                    </div>

                    {{-- SECTION 2: THÔNG TIN KHÁCH HÀNG --}}
                    <div class="border-t border-gray-100 pt-4">
                        <h3 class="text-lg font-bold text-[#0D47A1] mb-3">Thông tin khách hàng</h3>
                        <div class="space-y-3 pl-1">
                            <div class="flex items-center">
                                <label class="w-24 text-gray-800 font-medium text-sm">Họ Tên</label>
                                <input type="text" id="modal-customer-name" readonly 
                                    class="flex-1 px-4 py-1.5 bg-[#D9D9D94D] border border-[#99999980] rounded-xl text-[#333333] font-medium focus:outline-none uppercase">
                            </div>
                            <div class="flex items-center">
                                <label class="w-24 text-gray-800 font-medium text-sm">Số điện thoại</label>
                                <input type="text" id="modal-phone" readonly 
                                    class="flex-1 px-4 py-1.5 bg-[#D9D9D94D] border border-[#99999980] rounded-xl text-[#333333] font-medium focus:outline-none">
                            </div>
                            <div class="flex items-center">
                                <label class="w-24 text-gray-800 font-medium text-sm ">Địa chỉ</label>
                                <input name="address" type="text" id="modal-address"
                                    class="flex-1 px-4 py-1.5 bg-white border border-[#99999980] rounded-xl text-[#333333] font-medium focus:outline-none">
                            </div>
                        </div>
                    </div>

                    {{-- SECTION 3: THÔNG TIN ĐƠN HÀNG (TABLE) --}}
                    <div class="border-t border-gray-100 pt-4">
                        <h3 class="text-lg font-bold text-[#0D47A1] mb-3">Thông tin đơn hàng</h3>
                        <div class="border border-gray-300 rounded-lg overflow-hidden">
                            <table class="w-full text-sm text-gray-800">
                                <thead class="bg-gray-50 border-b border-gray-300">
                                    <tr>
                                        <th class="py-2 px-3 text-center border-r border-gray-200 w-10">#</th>
                                        <th class="py-2 px-3 text-left border-r border-gray-200">Sản phẩm</th>
                                        <th class="py-2 px-3 text-center border-r border-gray-200 w-20">Số lượng</th>
                                        <th class="py-2 px-3 text-right w-32">Giá tiền (VND)</th>
                                    </tr>
                                </thead>
                                <tbody id="modal-product-list" class="divide-y divide-gray-200">
                                    {{-- Javascript sẽ render dòng vào đây --}}
                                </tbody>
                                <tfoot class="bg-white text-xs sm:text-sm">
                                    {{-- Đã thêm class border-t border-gray-200 vào thẻ tr dưới đây --}}
                                    <tr class="border-t border-gray-200">
                                        <td colspan="3" class="py-2 px-3 text-right text-gray-600">Tổng tiền ban đầu</td>
                                        <td id="modal-subtotal" class="py-2 px-3 text-right text-gray-800">0</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="py-2 px-3 text-right text-gray-600">Giá trị giảm</td>
                                        <td id="modal-discount" class="py-2 px-3 text-right text-gray-800">0</td>
                                    </tr>
                                    <tr class="border-t border-gray-200">
                                        <td colspan="3" class="py-2 px-3 text-right font-bold text-gray-800 uppercase">TỔNG TIỀN</td>
                                        <td id="modal-total" class="py-2 px-3 text-right font-bold text-black">0</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="flex items-center mt-4">
                            <label class="mr-3 text-gray-800 font-medium whitespace-nowrap">Trạng thái</label>
                            <div class="relative w-full sm:w-48">
                                <select name="status" id="modal-status-select" class="w-full pl-4 pr-8 py-1.5 bg-white border border-gray-300 rounded-lg text-gray-800 font-medium appearance-none shadow-sm">
                                    <option value="pending">Chờ xác nhận</option>
                                    <option value="processing">Đang vận chuyển</option>
                                    <option value="completed">Hoàn tất</option>
                                    <option value="cancelled">Đã hủy</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none text-gray-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>                
                    </div>
                </div> 

                {{-- FOOTER --}}
                <div class="flex-none flex justify-center items-center gap-4 px-8 pb-8 pt-4 border-t border-gray-100 bg-white">
                    <button type="button" onclick="toggleModal('order-detail-modal')" 
                        class="px-8 py-2.5 bg-[#C4C4C4] hover:bg-gray-400 text-white rounded-lg font-semibold transition-colors">
                        Hủy
                    </button>

                    <button type="submit" 
                            class="px-8 py-2.5 bg-[#28A745] hover:bg-[#218838] text-white rounded-lg shadow-md font-semibold transition-colors">
                            Lưu thay đổi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>