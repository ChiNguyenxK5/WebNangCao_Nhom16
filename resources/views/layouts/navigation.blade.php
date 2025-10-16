<nav x-data="{ open: false }" class="pizza-navbar shadow-2xl border-b-4 border-orange-300/50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-24">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="pizza-logo group flex items-center space-x-4 hover:scale-110 transition-all duration-500">
                        <div class="bg-gradient-to-r from-yellow-300 via-orange-300 to-red-300 rounded-full p-3 shadow-2xl group-hover:shadow-orange-400/60 transition-all duration-500">
                            <span class="text-4xl pizza-icon">🍕</span>
                        </div>
                        <div class="text-white font-black text-2xl tracking-wide">
                            <span class="text-yellow-200 drop-shadow-lg">Pizza</span>
                            <span class="text-white drop-shadow-lg">Palace</span>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-2 sm:ms-12 sm:flex lg:space-x-6">
                    <a href="{{ route('dashboard') }}" 
                       class="nav-item group relative px-8 py-4 text-white font-bold rounded-2xl hover:bg-white/25 transition-all duration-500 transform {{ request()->routeIs('dashboard') ? 'bg-white/25 shadow-2xl scale-105' : '' }}">
                        <span class="flex items-center space-x-3">
                            <span class="text-2xl nav-item-icon">🏠</span>
                            <span class="text-lg">Trang Chủ</span>
                        </span>
                        <div class="absolute inset-0 rounded-2xl bg-gradient-to-r from-white/15 via-yellow-300/20 to-white/15 scale-0 group-hover:scale-100 transition-transform duration-500"></div>
                    </a>
                    
                    <a href="#" 
                       class="nav-item group relative px-8 py-4 text-white font-bold rounded-2xl hover:bg-white/25 transition-all duration-500 transform">
                        <span class="flex items-center space-x-3">
                            <span class="text-2xl nav-item-icon">🍕</span>
                            <span class="text-lg">Sản Phẩm</span>
                        </span>
                        <div class="absolute inset-0 rounded-2xl bg-gradient-to-r from-white/15 via-orange-300/20 to-white/15 scale-0 group-hover:scale-100 transition-transform duration-500"></div>
                    </a>
                    
                    <a href="#" 
                       class="nav-item group relative px-8 py-4 text-white font-bold rounded-2xl hover:bg-white/25 transition-all duration-500 transform">
                        <span class="flex items-center space-x-3">
                            <span class="text-2xl nav-item-icon">ℹ️</span>
                            <span class="text-lg">Giới Thiệu</span>
                        </span>
                        <div class="absolute inset-0 rounded-2xl bg-gradient-to-r from-white/15 via-blue-300/20 to-white/15 scale-0 group-hover:scale-100 transition-transform duration-500"></div>
                    </a>
                    
                    <a href="#" 
                       class="nav-item group relative px-8 py-4 text-white font-bold rounded-2xl hover:bg-white/25 transition-all duration-500 transform">
                        <span class="flex items-center space-x-3">
                            <span class="text-2xl nav-item-icon">📞</span>
                            <span class="text-lg">Liên Hệ</span>
                        </span>
                        <div class="absolute inset-0 rounded-2xl bg-gradient-to-r from-white/15 via-green-300/20 to-white/15 scale-0 group-hover:scale-100 transition-transform duration-500"></div>
                    </a>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 space-x-4">
                <!-- Notification Icon -->
                <div class="relative">
                    <button class="p-2 bg-white/20 hover:bg-white/30 rounded-full transition-all duration-300 transform hover:scale-110">
                        <span class="text-xl text-white">🔔</span>
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold px-1.5 py-0.5 rounded-full animate-pulse">2</span>
                    </button>
                </div>

                <!-- User Dropdown -->
                <x-dropdown align="right" width="64">
                    <x-slot name="trigger">
                        <button class="group inline-flex items-center px-4 py-2 bg-white/20 hover:bg-white/30 text-white font-semibold rounded-full transition-all duration-300 transform hover:scale-105 backdrop-blur-sm border border-white/30">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-gradient-to-r from-yellow-400 to-orange-400 rounded-full flex items-center justify-center font-bold text-orange-800">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <div class="hidden lg:block text-left">
                                    <div class="text-sm font-bold">{{ Auth::user()->name }}</div>
                                    <div class="text-xs text-white/80">{{ Auth::user()->email }}</div>
                                </div>
                                <svg class="fill-current h-4 w-4 transform group-hover:rotate-180 transition-transform duration-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="bg-gradient-to-r from-orange-50 to-pink-50 border border-orange-200">
                            <div class="px-4 py-3 border-b border-orange-200">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-gradient-to-r from-yellow-400 to-orange-400 rounded-full flex items-center justify-center font-bold text-orange-800">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-800">{{ Auth::user()->name }}</div>
                                        <div class="text-sm text-gray-600">{{ Auth::user()->email }}</div>
                                    </div>
                                </div>
                            </div>
                            
                            <x-dropdown-link :href="route('profile.edit')" class="flex items-center space-x-2 hover:bg-orange-100">
                                <span>👤</span>
                                <span>{{ __('Hồ Sơ') }}</span>
                            </x-dropdown-link>

                            <x-dropdown-link href="#" class="flex items-center space-x-2 hover:bg-orange-100">
                                <span>📋</span>
                                <span>Đơn Hàng Của Tôi</span>
                            </x-dropdown-link>

                            <x-dropdown-link href="#" class="flex items-center space-x-2 hover:bg-orange-100">
                                <span>⚙️</span>
                                <span>Cài Đặt</span>
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <div class="border-t border-orange-200">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')"
                                            onclick="event.preventDefault();
                                                        this.closest('form').submit();"
                                            class="flex items-center space-x-2 hover:bg-red-100 text-red-600">
                                        <span>🚪</span>
                                        <span>{{ __('Đăng Xuất') }}</span>
                                    </x-dropdown-link>
                                </form>
                            </div>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-3 rounded-full bg-white/20 hover:bg-white/30 text-white transition duration-300 transform hover:scale-110">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-gradient-to-b from-orange-600 to-red-600">
        <div class="pt-4 pb-3 space-y-2 px-4">
            <a href="{{ route('dashboard') }}" 
               class="flex items-center space-x-3 px-4 py-3 text-white font-semibold rounded-xl hover:bg-white/20 transition-all duration-300 {{ request()->routeIs('dashboard') ? 'bg-white/20' : '' }}">
                <span class="text-xl">🏠</span>
                <span>Trang Chủ</span>
            </a>
            
            <a href="#" 
               class="flex items-center space-x-3 px-4 py-3 text-white font-semibold rounded-xl hover:bg-white/20 transition-all duration-300">
                <span class="text-xl">🍕</span>
                <span>Menu Pizza</span>
            </a>
            
            <a href="#" 
               class="flex items-center space-x-3 px-4 py-3 text-white font-semibold rounded-xl hover:bg-white/20 transition-all duration-300">
                <span class="text-xl">ℹ️</span>
                <span>Giới Thiệu</span>
            </a>
            
            <a href="#" 
               class="flex items-center space-x-3 px-4 py-3 text-white font-semibold rounded-xl hover:bg-white/20 transition-all duration-300 relative">
                <span class="text-xl">🛒</span>
                <span>Giỏ Hàng</span>
                <span class="bg-yellow-400 text-orange-800 text-xs font-bold px-2 py-1 rounded-full">3</span>
            </a>
            
            <a href="#" 
               class="flex items-center space-x-3 px-4 py-3 text-white font-semibold rounded-xl hover:bg-white/20 transition-all duration-300">
                <span class="text-xl">📞</span>
                <span>Liên Hệ</span>
            </a>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-4 border-t border-white/20">
            <div class="px-4 mb-4">
                <div class="flex items-center space-x-3 bg-white/10 rounded-xl p-4">
                    <div class="w-12 h-12 bg-gradient-to-r from-yellow-400 to-orange-400 rounded-full flex items-center justify-center font-bold text-orange-800 text-xl">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <div class="font-bold text-white">{{ Auth::user()->name }}</div>
                        <div class="text-sm text-white/80">{{ Auth::user()->email }}</div>
                    </div>
                </div>
            </div>

            <div class="space-y-2 px-4">
                <a href="{{ route('profile.edit') }}" 
                   class="flex items-center space-x-3 px-4 py-3 text-white font-semibold rounded-xl hover:bg-white/20 transition-all duration-300">
                    <span class="text-xl">👤</span>
                    <span>Hồ Sơ</span>
                </a>

                <a href="#" 
                   class="flex items-center space-x-3 px-4 py-3 text-white font-semibold rounded-xl hover:bg-white/20 transition-all duration-300">
                    <span class="text-xl">📋</span>
                    <span>Đơn Hàng Của Tôi</span>
                </a>

                <a href="#" 
                   class="flex items-center space-x-3 px-4 py-3 text-white font-semibold rounded-xl hover:bg-white/20 transition-all duration-300">
                    <span class="text-xl">⚙️</span>
                    <span>Cài Đặt</span>
                </a>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit" 
                            class="w-full flex items-center space-x-3 px-4 py-3 text-white font-semibold rounded-xl hover:bg-red-500/30 transition-all duration-300">
                        <span class="text-xl">🚪</span>
                        <span>Đăng Xuất</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
