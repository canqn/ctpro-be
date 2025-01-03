<div x-data="{ isOpen: false }" class="relative">
    <!-- Mobile menu button -->
  <button @click="isOpen = !isOpen" class="lg:hidden fixed top-4 left-4 z-50 text-white bg-gray-800 hover:bg-gray-700 rounded-md p-2 focus:outline-none">
      <svg x-show="!isOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
      </svg>
      <svg x-show="isOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
      </svg>
  </button>

  <!-- Sidebar -->
  <div :class="{'translate-x-0': isOpen, '-translate-x-full': !isOpen}" class="fixed inset-y-0 left-0 z-40 w-64 bg-gray-900 transition-transform duration-300 ease-in-out transform lg:translate-x-0">
      <div class="flex flex-col h-full">
          <!-- Logo -->
          <div class="flex items-center justify-center h-16 bg-gray-800">
              <h1 class="text-xl font-bold text-white">Admin Dashboard</h1>
          </div>

          <!-- Search -->
          <div class="px-4 py-3">
              <div class="relative">
                  <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                      <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                      </svg>
                  </span>
                  <input type="text" class="w-full pl-10 pr-4 py-2 text-sm text-white bg-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Search...">
              </div>
          </div>

          <!-- Navigation -->
          <nav class="flex-1 px-2 py-4 overflow-y-auto">
              @php
                  $navItems = [
                      ['route' => 'admin/home', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6', 'label' => 'Home'],
                      ['route' => 'admin/users', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z', 'label' => 'Users'],
                      ['route' => 'admin.licenses.machines.index', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z', 'label' => 'Bản quyền'],
                      ['route' => 'admin.licenses.tax.index', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z', 'label' => 'MST'],
                      ['route' => 'admin/downloadlimits', 'icon' => 'M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4', 'label' => 'Quản lý lượt tải'],
                      ['route' => 'admin/profile', 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z', 'label' => 'Profile'],
                  ];
              @endphp

              @foreach($navItems as $item)
              <a href="{{ route($item['route']) }}"
                    class="flex items-center px-4 py-2 mt-2 text-gray-100 transition-colors duration-200 transform rounded-md
                            hover:bg-blue-600 hover:text-white {{ request()->routeIs($item['route']) ? 'bg-blue-600' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"></path>
                    </svg>
                    <span class="mx-4 font-medium">{{ $item['label'] }}</span>
                </a>

              @endforeach
          </nav>

          <!-- Logout -->
          <div class="p-4 border-t border-gray-700">
              <a href="{{ route('logout') }}" class="flex items-center text-red-500 hover:text-red-400">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                  </svg>
                  <span class="mx-4 font-medium">Logout</span>
              </a>
          </div>
      </div>
  </div>
</div>
