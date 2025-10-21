{{-- Sidebar --}}
<aside class="w-72 border-r border-gray-200 bg-white flex flex-col justify-between">
    <div>
        <div class="flex items-center gap-3 px-6 py-5 border-b border-gray-200">
            <img src="{{ asset('uploads/logopizza (1).png') }}" class="w-10 h-10 object-contain" />
            <span class="font-semibold text-lg text-gray-900">Pizza Company</span>
        </div>
        <nav class="mt-6 flex flex-col gap-6 px-6">
            <a href="{{ route('admin.dashboard') }}" 
               class="flex items-center gap-3 {{ request()->routeIs('admin.dashboard') ? 'text-indigo-600 font-semibold' : 'text-gray-700 hover:text-gray-900 font-medium' }}">
                <i class="fas fa-th-large"></i> Tổng quan
            </a>
            <a href="{{ route('admin.pizzas') }}" 
               class="flex items-center gap-3 {{ request()->routeIs('admin.pizzas*') ? 'text-indigo-600 font-semibold' : 'text-gray-700 hover:text-gray-900 font-medium' }}">
                <i class="fas fa-box"></i> Sản phẩm
            </a>
            <a href="{{ route('admin.orders.index') }}" 
               class="flex items-center gap-3 {{ request()->routeIs('admin.orders*') ? 'text-indigo-600 font-semibold' : 'text-gray-700 hover:text-gray-900 font-medium' }}">
                <i class="fas fa-shopping-cart"></i> Quản lý đơn hàng
            </a>
        </nav>
    </div>

    <div class="px-6 py-5 border-t border-gray-200">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center text-gray-600">
                <i class="fas fa-user"></i>
            </div>
            <div>
                <p class="text-gray-900 font-semibold text-sm">{{ auth()->user()->name }}</p>
                <p class="text-gray-500 text-xs">Quản trị viên</p>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="w-full flex items-center justify-center gap-2 border border-gray-300 rounded-md py-2 text-gray-900 font-semibold text-sm hover:bg-gray-100">
                <i class="fas fa-sign-out-alt"></i> Đăng xuất
            </button>
        </form>
    </div>
</aside>
