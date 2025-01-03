<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>@yield('title')</title>
    <!-- styles -->
    @include('panel.styles')
</head>

<body class="leading-normal tracking-normal gradient" style="font-family: 'Source Sans Pro', sans-serif;">
    <nav class="bg-white shadow-md border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 text-black text-xl font-bold">
                        <a href="#home">
                            <img class=" h-14" src="{{ asset('assets/images/logo-header.png') }}" alt="CTPro">
                        </a>

                    </div>
                    <div class="hidden md:block">
                        <div class="ml-10 flex items-baseline space-x-4">
                            <a href="{{ url('/') }}" class="text-black px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-100">Home</a>
                            <a href="#app" class="text-gray-700 hover:bg-gray-100 hover:text-black px-3 py-2 rounded-md text-sm font-medium">Tính năng</a>
                            <a href="#lienhe" class="text-gray-700 hover:bg-gray-100 hover:text-black px-3 py-2 rounded-md text-sm font-medium">Liên hệ</a>
                        </div>
                    </div>
                </div>
                <div class="hidden md:block">
                    <div class="ml-4 flex items-center md:ml-6">
                        @if (Route::has('login'))
                            @auth
                                <button class="bg-white p-1 rounded-full text-gray-800 hover:text-black focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-black">
                                    <span class="sr-only">View notifications</span>
                                    <!-- Heroicon name: outline/bell -->
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                    </svg>
                                </button>
                                <!-- Profile dropdown -->
                                <div x-data="{show: false}" x-on:click.away="show = false" class="ml-3 relative">
                                    <div>
                                        <button x-on:click="show = !show" type="button" class="max-w-xs bg-white rounded-full flex items-center text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-black" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                            <span class="sr-only">Open user menu</span>
                                            <img class="h-8 w-8 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                                        </button>
                                    </div>
                                    <div x-show="show" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-black ring-1 ring-white ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                                        <a href="{{ url('/profile') }}" class="block px-4 py-2 text-sm text-white" role="menuitem" tabindex="-1" id="user-menu-item-0">Your Profile</a>

                                        <a href="#" class="block px-4 py-2 text-sm text-white" role="menuitem" tabindex="-1" id="user-menu-item-1">Settings</a>

                                        <a href="{{ url('/logout') }}" class="block px-4 py-2 text-sm text-white" role="menuitem" tabindex="-1" id="user-menu-item-2">Sign out</a>
                                    </div>
                                </div>
                                @if(Auth::user()->isAdmin())
                                    <a href="{{ url('/admin/home') }}" class="ml-4 text-gray-700 hover:text-black px-3 py-2 rounded-md text-sm font-medium">Admin Home</a>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="text-gray-700 hover:text-black px-3 py-2 rounded-md text-sm font-medium">Đăng nhập</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="bg-gray-900 text-white px-4 py-2 rounded-md text-sm font-medium">Dùng thử</a>
                                @endif
                            @endauth
                        @endif
                    </div>

                </div>
                <div class="-mr-2 flex md:hidden">
                    <!-- Mobile menu button -->
                    <button type="button" class="bg-white inline-flex items-center justify-center p-2 rounded-md text-gray-800 hover:text-black hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-black" aria-controls="mobile-menu" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                </div>

                <!-- Mobile menu, show/hide based on menu state. -->
                <div class="md:hidden bg-white" id="mobile-menu">
                    <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                        <a href="#" class="bg-gray-200 text-black block px-3 py-2 rounded-md text-base font-medium">Home</a>
                        <a href="#" class="text-gray-800 hover:bg-gray-300 hover:text-black block px-3 py-2 rounded-md text-base font-medium">About Us</a>
                        <a href="#" class="text-gray-800 hover:bg-gray-300 hover:text-black block px-3 py-2 rounded-md text-base font-medium">Contact Us</a>
                    </div>
                    <div class="pt-4 pb-3 border-t border-gray-300">
                        <div class="flex items-center px-5">
                            <div class="flex-shrink-0">
                                <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                            </div>
                            <div class="ml-3">
                                <div class="text-base font-medium leading-none text-black">Tom Cook</div>
                                <div class="text-sm font-medium leading-none text-gray-600">tom@example.com</div>
                            </div>
                            <button class="ml-auto bg-white flex-shrink-0 p-1 rounded-full text-gray-800 hover:text-black focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-black">
                                <span class="sr-only">View notifications</span>
                                <!-- Heroicon name: outline/bell -->
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                            </button>
                        </div>
                        <div class="mt-3 px-2 space-y-1">
                            <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-800 hover:text-black hover:bg-gray-200">Your Profile</a>

                            <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-800 hover:text-black hover:bg-gray-200">Settings</a>

                            <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-800 hover:text-black hover:bg-gray-200">Sign out</a>
                        </div>
                    </div>
                </div>

    </nav>
        <main>
            <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                <div>@yield('contents')</div>
            </div>
        </main>

         <!-- Footer -->
 <footer class="bg-blue-600 text-white py-8">
    <div class="container mx-auto grid grid-cols-1 md:grid-cols-3 gap-8 px-4">
        <!-- Logo và Mô tả -->
        <div>
            <h2 class="text-2xl font-bold mb-4">CTPro- Chuyên xử lý hoá đơn</h2>

            <p>Cung cấp các dịch vụ tư vấn chuyên nghiệp và miễn phí cho khách hàng.</p>
        </div>

        <!-- Liên kết nhanh -->
        <div>
            <h3 class="text-xl font-semibold mb-4">Liên kết nhanh</h3>
            <ul>
                <li class="mb-2"><a href="#" class="hover:underline">Trang chủ</a></li>
                <li class="mb-2"><a href="#" class="hover:underline">Về chúng tôi</a></li>
                <li class="mb-2"><a href="#" class="hover:underline">Dịch vụ</a></li>
                <li class="mb-2"><a href="#" class="hover:underline">Liên hệ</a></li>
            </ul>
        </div>

        <!-- Thông tin liên hệ -->
        <div>
            <h3 class="text-xl font-semibold mb-4">Thông tin liên hệ</h3>
            {{-- <p class="mb-2"><i class='bx bx-map mr-2'></i>123 Đường ABC, Thành phố XYZ</p> --}}
            <p class="mb-2"><i class='bx bx-phone mr-2'></i>+84 0914 659 519</p>
            <p class="mb-2"><i class='bx bx-envelope mr-2'></i>nvcqnn@gmail.com</p>

            <!-- Biểu tượng mạng xã hội -->
            <div class="flex space-x-4 mt-4">
                <a href="#" class="hover:text-gray-400"><i class='bx bxl-facebook'></i></a>
                <a href="#" class="hover:text-gray-400"><i class='bx bxl-twitter'></i></a>
                <a href="#" class="hover:text-gray-400"><i class='bx bxl-linkedin'></i></a>
            </div>
        </div>
    </div>

    <!-- Dòng bản quyền -->
    <div class="text-center mt-8">
        <p>© 2024 Dịch Vụ Tư Vấn Miễn Phí. All rights reserved.</p>
    </div>
</footer>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
</body>

</html>
