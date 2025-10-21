<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết đơn hàng #{{ $order->id }} - Admin</title>
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
            <div class="max-w-5xl mx-auto">
                <!-- Header -->
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-3xl font-bold text-gray-800">Chi tiết đơn hàng #{{ $order->id }}</h2>
                    <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                        <i class="fas fa-arrow-left mr-2"></i>Quay lại danh sách
                    </a>
                </div>

                <!-- Success Message -->
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Order Info Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Customer Info -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                            <i class="fas fa-user text-orange-600"></i>
                            Thông tin khách hàng
                        </h3>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tên:</span>
                                <span class="font-medium">{{ $order->user->name }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Email:</span>
                                <span class="font-medium">{{ $order->user->email }}</span>
                            </div>
                            @if($order->user->phone)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Số điện thoại:</span>
                                <span class="font-medium">{{ $order->user->phone }}</span>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Order Status -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                            <i class="fas fa-info-circle text-orange-600"></i>
                            Thông tin đơn hàng
                        </h3>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Mã đơn:</span>
                                <span class="font-medium">#{{ $order->id }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Ngày tạo:</span>
                                <span class="font-medium">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Trạng thái:</span>
                                @php
                                    $statusConfig = [
                                        'pending' => ['text' => 'Chờ xử lý', 'class' => 'bg-yellow-100 text-yellow-800'],
                                        'processing' => ['text' => 'Đang xử lý', 'class' => 'bg-blue-100 text-blue-800'],
                                        'ordered' => ['text' => 'Đã đặt hàng', 'class' => 'bg-green-100 text-green-800'],
                                        'cancelled' => ['text' => 'Đã hủy', 'class' => 'bg-red-100 text-red-800'],
                                    ];
                                    $config = $statusConfig[$order->status] ?? ['text' => $order->status, 'class' => 'bg-gray-100 text-gray-800'];
                                @endphp
                                <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $config['class'] }}">
                                    {{ $config['text'] }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Update Status Form -->
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                        <i class="fas fa-sync-alt text-orange-600"></i>
                        Cập nhật trạng thái đơn hàng
                    </h3>
                    <form method="POST" action="{{ route('admin.orders.updateStatus', $order) }}" class="flex gap-4 items-end">
                        @csrf
                        @method('PATCH')
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Trạng thái mới</label>
                            <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                                <option value="ordered" {{ $order->status == 'ordered' ? 'selected' : '' }}>Đã đặt hàng</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                            </select>
                        </div>
                        <button type="submit" class="px-6 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 font-medium">
                            <i class="fas fa-save mr-2"></i>Cập nhật trạng thái
                        </button>
                    </form>
                </div>

                <!-- Order Items -->
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                        <i class="fas fa-list text-orange-600"></i>
                        Danh sách sản phẩm
                    </h3>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Sản phẩm</th>
                                    <th class="px-4 py-3 text-center text-sm font-medium text-gray-700">Kích thước</th>
                                    <th class="px-4 py-3 text-center text-sm font-medium text-gray-700">Số lượng</th>
                                    <th class="px-4 py-3 text-right text-sm font-medium text-gray-700">Đơn giá</th>
                                    <th class="px-4 py-3 text-right text-sm font-medium text-gray-700">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($order->items as $item)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-4">
                                            <div class="flex items-center gap-3">
                                                @if($item->pizza && $item->pizza->image)
                                                    <img src="{{ asset($item->pizza->image) }}" 
                                                         alt="{{ $item->pizza_name }}" 
                                                         class="w-16 h-16 object-cover rounded">
                                                @endif
                                                <div>
                                                    <div class="font-medium text-gray-900">{{ $item->pizza_name }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-4 text-center">
                                            @php
                                                $sizeLabels = [
                                                    'small' => 'Nhỏ',
                                                    'medium' => 'Vừa',
                                                    'large' => 'Lớn'
                                                ];
                                            @endphp
                                            <span class="inline-block px-3 py-1 text-sm font-medium bg-gray-100 rounded">
                                                {{ $sizeLabels[$item->size] ?? $item->size }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-4 text-center font-medium">
                                            {{ $item->quantity }}
                                        </td>
                                        <td class="px-4 py-4 text-right text-gray-900">
                                            {{ number_format($item->price, 0, ',', '.') }}đ
                                        </td>
                                        <td class="px-4 py-4 text-right font-semibold text-gray-900">
                                            {{ number_format($item->price * $item->quantity, 0, ',', '.') }}đ
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                        <i class="fas fa-calculator text-orange-600"></i>
                        Tổng kết đơn hàng
                    </h3>
                    <div class="space-y-3">
                        <div class="flex justify-between text-gray-700">
                            <span>Tạm tính:</span>
                            <span class="font-medium">{{ number_format($order->subtotal, 0, ',', '.') }}đ</span>
                        </div>
                        
                        @if($order->discount_amount > 0)
                            <div class="flex justify-between text-green-600">
                                <span>Giảm giá ({{ $order->coupon_code }}):</span>
                                <span class="font-medium">-{{ number_format($order->discount_amount, 0, ',', '.') }}đ</span>
                            </div>
                        @endif
                        
                        <div class="border-t pt-3 flex justify-between text-lg font-bold text-gray-900">
                            <span>Tổng cộng:</span>
                            <span class="text-orange-600">{{ number_format($order->total, 0, ',', '.') }}đ</span>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
