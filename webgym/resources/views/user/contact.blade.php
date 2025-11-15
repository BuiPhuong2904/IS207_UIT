@extends('user.layouts.user_layout')

@section('title', 'GRYND - Trang chủ')

@section('content')

    <section>
        <img src="{{ asset('images/about/about.jpg') }}"
            alt="Grynd Gym"
            class="w-full h-64 object-cover object-[center_65%]">
    </section>

    <div class="flex flex-col md:flex-row justify-center gap-10 px-6 py-10 max-w-7xl mx-auto">

        <div class="flex-1 space-y-5">

            <h1 class="text-4xl font-semibold mb-3 text-[#0D47A1] font-[Montserrat]">Liên hệ với GRYND</h1>
            <p class="text-[#333333] font-[Open_Sans]">
                Chúng tôi luôn sẵn sàng hỗ trợ bạn.<br>
                Hãy gửi tin nhắn hoặc liên hệ qua các chi nhánh dưới đây.
            </p>
    
            <div class="bg-white shadow-md rounded-2xl p-5 hover:shadow-lg transition">
                <h2 class="font-semibold text-lg text-[#292929] font-[Montserrat]">Chi nhánh Võ Thị Sáu</h2>
                <p class="mt-2 text-[#333333] font-[Open_Sans]">📍 23/8, Đường Cách Mạng Tháng 8, Phường Võ Thị Sáu, TP.HCM</p>
                <p class="text-[#333333] font-[Open_Sans]">📞 090 912 3456</p>
            </div>

            <div class="bg-white shadow-md rounded-2xl p-5 hover:shadow-lg transition">
                <h2 class="font-semibold text-lg text-[#292929] font-[Montserrat]">Chi nhánh Lý Thường Kiệt</h2>
                <p class="mt-2 text-[#333333] font-[Open_Sans]">📍 Số 77, Đường Lý Thường Kiệt, Phường 14, TP.HCM</p>
                <p class="text-[#333333] font-[Open_Sans]">📞 091 234 5678</p>
            </div>

            <div class="bg-white shadow-md rounded-2xl p-5 hover:shadow-lg transition">
                <h2 class="font-semibold text-lg text-[#292929] font-[Montserrat]">Chi nhánh Linh Xuân</h2>
                <p class="mt-2 text-[#333333] font-[Open_Sans]">📍 Số 12B, Khu phố 4, Phường Linh Xuân, TP.HCM</p>
                <p class="text-[#333333] font-[Open_Sans]">📞 093 812 3456</p>
            </div>

            <div class="bg-white shadow-md rounded-2xl p-5 hover:shadow-lg transition">
                <h2 class="font-semibold text-lg text-[#292929] font-[Montserrat]">Chi nhánh Điện Biên</h2>
                <p class="mt-2 text-[#333333] font-[Open_Sans]">📍 Số 22, Đường Trần Phú, Phường Điện Biên, Thành phố Hà Nội</p>
                <p class="text-[#333333] font-[Open_Sans]">📞 090 123 4567</p>
            </div>

            <div class="bg-white shadow-md rounded-2xl p-5 hover:shadow-lg transition">
                <h2 class="font-semibold text-lg text-[#292929] font-[Montserrat]">Chi nhánh Hoàng Diệu</h2>
                <p class="mt-2 text-[#333333] font-[Open_Sans]">📍 Số 34, Đường Hoàng Diệu, Phường Điện Biên, Thành phố Hà Nội</p>
                <p class="text-[#333333] font-[Open_Sans]">📞 090 234 5678</p>
            </div>

            <div class="bg-white shadow-md rounded-2xl p-5 hover:shadow-lg transition">
                <h2 class="font-semibold text-lg text-[#292929] font-[Montserrat]">Chi nhánh Trung Hòa</h2>
                <p class="mt-2 text-[#333333] font-[Open_Sans]">📍 Số 56, Đường Trung Kính, Phường Trung Hòa, Thành phố Hà Nội</p>
                <p class="text-[#333333] font-[Open_Sans]">📞 090 912 3456</p>
            </div>

            <div class="bg-white shadow-md rounded-2xl p-5 hover:shadow-lg transition">
                <h2 class="font-semibold text-lg text-[#292929] font-[Montserrat]">Chi nhánh Đà Nẵng</h2>
                <p class="mt-2 text-[#333333] font-[Open_Sans]">📍 Số 101, Đường Lê Hồng Phong, Phường Phước Ninh, Thành phố Đà Nẵng</p>
                <p class="text-[#333333] font-[Open_Sans]">📞 098 765 4321</p>
            </div>
        </div>

        <div class="w-full md:w-1/3 bg-white p-6 rounded-lg shadow-md self-start sticky top-24">
            <h2 class="text-xl font-semibold mb-6 text-[#1e87db] font-[Montserrat]">Gửi tin nhắn cho chúng tôi</h2>
            <form action="#" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block mb-1 text-[#333333] font-[Open_Sans]">Họ và tên</label>
                    <input type="text" name="name" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div>
                    <label class="block mb-1 text-[#333333] font-[Open_Sans]">Email</label>
                    <input type="email" name="email" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div>
                    <label class="block mb-1 text-[#333333] font-[Open_Sans]">Chủ đề</label>
                    <input type="text" name="subject" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div>
                    <label class="block mb-1 text-[#333333] font-[Open_Sans]">Nội dung</label>
                    <textarea name="message" rows="4" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none"></textarea>
                </div>
                <button type="submit" class="w-full bg-[#1b7ac5] text-white py-2 rounded-lg hover:bg-[#166ba8] transition duration-300 font-[Open_Sans]">
                    Gửi tin nhắn
                </button>
            </form>
        </div>

    </div>

@endsection