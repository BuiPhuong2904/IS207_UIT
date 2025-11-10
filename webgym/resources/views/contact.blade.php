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
                <h2 class="font-semibold text-lg text-[#292929] font-[Montserrat]">Grynd Gò Vấp</h2>
                <p class="mt-2 text-[#333333] font-[Open_Sans]">📍 25 Nguyễn Văn Lượng, Phường 6, Quận Gò Vấp, TP. Hồ Chí Minh</p>
                <p class="text-[#333333] font-[Open_Sans]">📞 (028) 3894 5566</p>
            </div>

            <div class="bg-white shadow-md rounded-2xl p-5 hover:shadow-lg transition">
                <h2 class="font-semibold text-lg text-[#292929] font-[Montserrat]">Grynd Quận 1</h2>
                <p class="mt-2 text-[#333333] font-[Open_Sans]">📍 120 Lê Lợi, Phường Bến Thành, Quận 1, TP. Hồ Chí Minh</p>
                <p class="text-[#333333] font-[Open_Sans]">📞 (028) 3823 7788</p>
            </div>

            <div class="bg-white shadow-md rounded-2xl p-5 hover:shadow-lg transition">
                <h2 class="font-semibold text-lg text-[#292929] font-[Montserrat]">Grynd Thủ Đức</h2>
                <p class="mt-2 text-[#333333] font-[Open_Sans]">📍 45 Võ Văn Ngân, Phường Linh Chiểu, TP. Thủ Đức, TP. Hồ Chí Minh</p>
                <p class="text-[#333333] font-[Open_Sans]">📞 (028) 3722 9911</p>
            </div>

            <div class="bg-white shadow-md rounded-2xl p-5 hover:shadow-lg transition">
                <h2 class="font-semibold text-lg text-[#292929] font-[Montserrat]">Grynd Bình Thạnh</h2>
                <p class="mt-2 text-[#333333] font-[Open_Sans]">📍 215 Phan Đăng Lưu, Phường 1, Quận Bình Thạnh, TP. Hồ Chí Minh</p>
                <p class="text-[#333333] font-[Open_Sans]">📞 (028) 3555 2244</p>
            </div>

            <div class="bg-white shadow-md rounded-2xl p-5 hover:shadow-lg transition">
                <h2 class="font-semibold text-lg text-[#292929] font-[Montserrat]">Grynd Tân Bình</h2>
                <p class="mt-2 text-[#333333] font-[Open_Sans]">📍 88 Cộng Hòa, Phường 4, Quận Tân Bình, TP. Hồ Chí Minh</p>
                <p class="text-[#333333] font-[Open_Sans]">📞 (028) 3811 7733</p>
            </div>

            <div class="bg-white shadow-md rounded-2xl p-5 hover:shadow-lg transition">
                <h2 class="font-semibold text-lg text-[#292929] font-[Montserrat]">Grynd Hà Nội</h2>
                <p class="mt-2 text-[#333333] font-[Open_Sans]">📍 18 Trần Duy Hưng, Quận Cầu Giấy, Hà Nội</p>
                <p class="text-[#333333] font-[Open_Sans]">📞 (024) 3776 8899</p>
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