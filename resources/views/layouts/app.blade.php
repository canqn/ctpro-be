<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard')</title>

    <!-- Styles -->
    @include('panel.styles')
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
</head>
<body class="h-full">
    <div x-data="{ sidebarOpen: false }" class="min-h-full">
        <!-- Mobile sidebar overlay -->
        <div x-show="sidebarOpen" class="fixed inset-0 z-40 flex md:hidden" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-gray-600 bg-opacity-75" aria-hidden="true" @click="sidebarOpen = false"></div>

            <!-- Mobile sidebar -->
            <div class="relative flex-1 flex flex-col max-w-xs w-full pt-5 pb-4 bg-gray-800">
                <div class="absolute top-0 right-0 -mr-12 pt-2">
                    <button type="button" class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" @click="sidebarOpen = false">
                        <span class="sr-only">Close sidebar</span>
                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                @include('panel.sidebar')
            </div>
        </div>

        <!-- Static sidebar for desktop -->
        <div class=" md:flex md:w-64 md:flex-col md:fixed md:inset-y-0">
            @include('panel.sidebar')
        </div>

        <div class="md:pl-64 flex flex-col flex-1">
            <!-- Top navbar -->

                @include('panel.navbar')


            <main class="flex-1">
                <div class="py-6">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                        <!-- Main content -->
                        @yield('contents')
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Scripts -->
     @include('panel.scripts')
</body>
</html>
