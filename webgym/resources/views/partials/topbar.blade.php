<header class="bg-white border-b border-gray-200" x-data="{ open: false, hasNewNotification: false }">
    <div class="flex justify-between items-center p-4">
        
        <div>
            <h1 class="text-3xl font-bold text-[#0f477e]">Overview</h1>
        </div>
        
        <div class="flex items-center space-x-4">
            
            <form action="#" method="GET" class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                </div>
                <input type="text" name="search" placeholder="Tìm kiếm . . ." 
                    class="bg-gray-100 border-none rounded-lg py-2 pl-10 pr-4 w-80 text-sm placeholder-gray-500
                        focus:ring-1 focus:ring-gray-300 focus:border-gray-300 focus:outline-none">
            </form>

            <button class="p-2 rounded-full bg-gray-100 text-[#1976D2] hover:bg-gray-200 hover:text-gray-700">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
            </button>
            
            <button class="p-2 rounded-full bg-gray-100 text-[#FF3B30] hover:bg-gray-200 hover:text-gray-700 relative">
                <span x-show="hasNewNotification" 
                    class="absolute top-2 right-2 block h-2 w-2 rounded-full bg-red-500"></span>
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                </svg>
            </button>

            <div class="relative">
                
                <button @click="open = !open"
                    class="relative block h-12 w-12 rounded-full overflow-hidden border-2 border-transparent 
                        bg-gray-100 hover:bg-gray-200 transition duration-200 ease-in-out
                        focus:outline-none focus:ring-0 focus:border-none">
                    <img src="{{ Auth::user()->image_url ?? 'https://res.cloudinary.com/dna9qbejm/image/upload/v1762341321/ava_ntqezy.jpg' }}" 
                        alt="User Avatar" 
                        class="h-full w-full object-cover rounded-full">
                </button>

                <div x-show="open"
                    @click.away="open = false"
                    x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="transform opacity-100 scale-100"
                    x-transition:leave-end="transform opacity-0 scale-95"
                    class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-2xl z-10"
                    style="display: none;">
                    
                    <div class="py-1">
                        <div class="px-4 py-2 text-xs text-gray-500 border-b">
                            Xin chào, {{ Auth::user()->full_name ?? 'User' }}
                        </div>

                        <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 font-semibold">
                            Hồ sơ
                        </a>
                        
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 font-semibold">
                                Đăng xuất
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</header>