<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý đơn hàng - Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-lg">
            <div class="p-6 border-b">
                <h1 class="text-2xl font-bold text-gray-800">Admin Panel</h1>
            </div>
            <nav class="p-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 text-gray-700 hover:text-gray-900 font-medium">
                    <i class="fas fa-chart-line"></i> Tổng quan
                </a>
                <a href="{{ route('admin.pizzas') }}" class="flex items-center gap-3 text-gray-700 hover:text-gray-900 font-medium">
                    <i class="fas fa-pizza-slice"></i> Quản lý Pizza
                </a>
                <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-3 text-orange-600 hover:text-orange-700 font-bold">
                    <i class="fas fa-shopping-cart"></i> Quản lý đơn hàng
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8">
            <div class="max-w-7xl mx-auto">
                <!-- Header -->
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-3xl font-bold text-gray-800">Quản lý đơn hàng</h2>
                    <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                        <i class="fas fa-arrow-left mr-2"></i>Quay lại
                    </a>
                </div>

                <!-- Status Filter Tabs -->
                <div class="bg-white rounded-lg shadow mb-6">
                    <div class="flex border-b">
                        <a href="{{ route('admin.orders.index') }}" 
                           class="px-6 py-4 text-center {{ !request('status') ? 'border-b-2 border-orange-500 text-orange-600 font-semibold' : 'text-gray-600 hover:text-gray-900' }}">
                            Tất cả ({{ $statusCounts['all'] }})
                        </a>
                        <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" 
                           class="px-6 py-4 text-center {{ request('status') == 'pending' ? 'border-b-2 border-orange-500 text-orange-600 font-semibold' : 'text-gray-600 hover:text-gray-900' }}">
                            Chờ xử lý ({{ $statusCounts['pending'] }})
                        </a>
                        <a href="{{ route('admin.orders.index', ['status' => 'processing']) }}" 
                           class="px-6 py-4 text-center {{ request('status') == 'processing' ? 'border-b-2 border-orange-500 text-orange-600 font-semibold' : 'text-gray-600 hover:text-gray-900' }}">
                            Đang xử lý ({{ $statusCounts['processing'] }})
                        </a>
                        <a href="{{ route('admin.orders.index', ['status' => 'ordered']) }}" 
                           class="px-6 py-4 text-center {{ request('status') == 'ordered' ? 'border-b-2 border-orange-500 text-orange-600 font-semibold' : 'text-gray-600 hover:text-gray-900' }}">
                            Đã đặt hàng ({{ $statusCounts['ordered'] }})
                        </a>
                        <a href="{{ route('admin.orders.index', ['status' => 'cancelled']) }}" 
                           class="px-6 py-4 text-center {{ request('status') == 'cancelled' ? 'border-b-2 border-orange-500 text-orange-600 font-semibold' : 'text-gray-600 hover:text-gray-900' }}">
                            Đã hủy ({{ $statusCounts['cancelled'] }})
                        </a>
                    </div>
                </div>

                <!-- Search Form -->
                <div class="bg-white rounded-lg shadow p-4 mb-6">
                    <form method="GET" action="{{ route('admin.orders.index') }}" class="flex gap-4">
                        @if(request('status'))
                            <input type="hidden" name="status" value="{{ request('status') }}">
                        @endif
                        <div class="flex-1">
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   placeholder="Tìm kiếm theo ID đơn hàng, tên khách hàng, email..." 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                        </div>
                        <button type="submit" class="px-6 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600">
                            <i class="fas fa-search mr-2"></i>Tìm kiếm
                        </button>
                        @if(request('search'))
                            <a href="{{ route('admin.orders.index', ['status' => request('status')]) }}" 
                               class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                                <i class="fas fa-times mr-2"></i>Xóa
                            </a>
                        @endif
                    </form>
                </div>

                <!-- Success Message -->
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Orders Table -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Khách hàng</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Số lượng món</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tổng tiền</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trạng thái</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ngày tạo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($orders as $order)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        #{{ $order->id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $order->user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $order->user->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $order->items->sum('quantity') }} món
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                        {{ number_format($order->total, 0, ',', '.') }}đ
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $statusConfig = [
                                                'pending' => ['text' => 'Chờ xử lý', 'class' => 'bg-yellow-100 text-yellow-800'],
                                                'processing' => ['text' => 'Đang xử lý', 'class' => 'bg-blue-100 text-blue-800'],
                                                'ordered' => ['text' => 'Đã đặt hàng', 'class' => 'bg-green-100 text-green-800'],
                                                'cancelled' => ['text' => 'Đã hủy', 'class' => 'bg-red-100 text-red-800'],
                                            ];
                                            $config = $statusConfig[$order->status] ?? ['text' => $order->status, 'class' => 'bg-gray-100 text-gray-800'];
                                        @endphp
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $config['class'] }}">
                                            {{ $config['text'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $order->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <a href="{{ route('admin.orders.show', $order) }}" 
                                           class="text-orange-600 hover:text-orange-900 font-medium">
                                            <i class="fas fa-eye mr-1"></i>Xem chi tiết
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                        <i class="fas fa-inbox text-4xl mb-4"></i>
                                        <p class="text-lg">Không có đơn hàng nào</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($orders->hasPages())
                    <div class="mt-6">
                        {{ $orders->links() }}
                    </div>
                @endif
            </div>
        </main>
    </div>
</body>
</html>
