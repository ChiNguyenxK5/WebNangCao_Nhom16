<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tổng quan - Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-gray-50 text-gray-900 flex min-h-screen">

    {{-- Sidebar --}}
    <aside class="w-72 border-r border-gray-200 bg-white flex flex-col justify-between">
        <div>
            <div class="flex items-center gap-3 px-6 py-5 border-b border-gray-200">
                <img src="{{ asset('uploads/logopizza (1).png') }}" class="w-10 h-10 object-contain" />
                <span class="font-semibold text-lg text-gray-900">Pizza Company</span>
            </div>
            <nav class="mt-6 flex flex-col gap-6 px-6">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 text-indigo-600 font-semibold">
                    <i class="fas fa-th-large"></i> Tổng quan
                </a>
                <a href="{{ route('admin.pizzas') }}" class="flex items-center gap-3 text-gray-700 hover:text-gray-900 font-medium">
                    <i class="fas fa-box"></i> Sản phẩm
                </a>
                <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-3 text-gray-700 hover:text-gray-900 font-medium">
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

    {{-- Nội dung chính --}}
    <main class="flex-1 p-6">
        <div class="mb-4 text-sm text-gray-600">Tổng quan /
            <span class="text-indigo-600">Dashboard</span>
        </div>

        <h1 class="text-3xl font-extrabold text-gray-900 flex items-center gap-2 mb-1">
            <i class="fas fa-chart-line text-indigo-600"></i> Tổng quan hệ thống
        </h1>
        <p class="text-gray-700 mb-6">Thống kê tổng quan về đơn hàng và sản phẩm</p>

        {{-- Statistics Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            {{-- Total Orders --}}
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg p-6 text-white">
                <div class="flex items-center justify-between mb-2">
                    <div>
                        <p class="text-blue-100 text-sm font-medium">Tổng đơn hàng</p>
                        <h3 class="text-3xl font-bold">{{ $totalOrders }}</h3>
                    </div>
                    <div class="bg-blue-400 bg-opacity-30 rounded-full p-4">
                        <i class="fas fa-shopping-cart text-2xl"></i>
                    </div>
                </div>
                <p class="text-blue-100 text-xs">Tất cả đơn hàng trong hệ thống</p>
            </div>

            {{-- Total Revenue --}}
            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg p-6 text-white">
                <div class="flex items-center justify-between mb-2">
                    <div>
                        <p class="text-green-100 text-sm font-medium">Tổng doanh thu</p>
                        <h3 class="text-3xl font-bold">{{ number_format($totalRevenue / 1000, 0) }}K</h3>
                    </div>
                    <div class="bg-green-400 bg-opacity-30 rounded-full p-4">
                        <i class="fas fa-dollar-sign text-2xl"></i>
                    </div>
                </div>
                <p class="text-green-100 text-xs">{{ number_format($totalRevenue, 0, ',', '.') }}đ</p>
            </div>

            {{-- Completed Orders --}}
            <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-lg shadow-lg p-6 text-white">
                <div class="flex items-center justify-between mb-2">
                    <div>
                        <p class="text-emerald-100 text-sm font-medium">Đơn hoàn thành</p>
                        <h3 class="text-3xl font-bold">{{ $orderStats['completed'] }}</h3>
                    </div>
                    <div class="bg-emerald-400 bg-opacity-30 rounded-full p-4">
                        <i class="fas fa-check-circle text-2xl"></i>
                    </div>
                </div>
                <p class="text-emerald-100 text-xs">Đơn hàng đã hoàn thành</p>
            </div>

            {{-- Total Pizzas --}}
            <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg shadow-lg p-6 text-white">
                <div class="flex items-center justify-between mb-2">
                    <div>
                        <p class="text-orange-100 text-sm font-medium">Tổng sản phẩm</p>
                        <h3 class="text-3xl font-bold">{{ $totalPizzas }}</h3>
                    </div>
                    <div class="bg-orange-400 bg-opacity-30 rounded-full p-4">
                        <i class="fas fa-pizza-slice text-2xl"></i>
                    </div>
                </div>
                <p class="text-orange-100 text-xs">Sản phẩm pizza trong kho</p>
            </div>
        </div>

        {{-- Charts Section --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            {{-- Order Status Chart --}}
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <i class="fas fa-chart-pie text-indigo-600"></i>
                    Thống kê trạng thái đơn hàng
                </h2>
                <div class="flex justify-center items-center" style="height: 300px;">
                    <canvas id="orderStatusChart"></canvas>
                </div>
                <div class="mt-4 grid grid-cols-2 gap-3">
                    <div class="flex items-center gap-2">
                        <span class="w-4 h-4 bg-yellow-500 rounded-full"></span>
                        <span class="text-sm text-gray-700">Chờ xử lý: <strong>{{ $orderStats['pending'] }}</strong></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-4 h-4 bg-blue-500 rounded-full"></span>
                        <span class="text-sm text-gray-700">Đang xử lý: <strong>{{ $orderStats['processing'] }}</strong></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-4 h-4 bg-green-500 rounded-full"></span>
                        <span class="text-sm text-gray-700">Đã đặt hàng: <strong>{{ $orderStats['ordered'] }}</strong></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-4 h-4 bg-emerald-500 rounded-full"></span>
                        <span class="text-sm text-gray-700">Hoàn thành: <strong>{{ $orderStats['completed'] }}</strong></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-4 h-4 bg-red-500 rounded-full"></span>
                        <span class="text-sm text-gray-700">Đã hủy: <strong>{{ $orderStats['cancelled'] }}</strong></span>
                    </div>
                </div>
            </div>

            {{-- Revenue Summary --}}
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <i class="fas fa-money-bill-wave text-green-600"></i>
                    Tổng quan doanh thu
                </h2>
                <div class="space-y-4">
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg p-6 border border-green-200">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-gray-700 font-medium">Tổng doanh thu</span>
                            <i class="fas fa-chart-line text-green-600 text-xl"></i>
                        </div>
                        <p class="text-3xl font-bold text-green-600">{{ number_format($totalRevenue, 0, ',', '.') }}đ</p>
                        <p class="text-sm text-gray-600 mt-1">Từ {{ $totalOrders }} đơn hàng</p>
                    </div>

                    @php
                        $avgOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;
                        $completedRevenue = \App\Models\Order::where('status', 'completed')->sum('total');
                    @endphp

                    <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Giá trị trung bình/đơn</p>
                                <p class="text-xl font-bold text-blue-600">{{ number_format($avgOrderValue, 0, ',', '.') }}đ</p>
                            </div>
                            <i class="fas fa-calculator text-blue-400 text-2xl"></i>
                        </div>
                    </div>

                    <div class="bg-emerald-50 rounded-lg p-4 border border-emerald-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Doanh thu từ đơn hoàn thành</p>
                                <p class="text-xl font-bold text-emerald-600">{{ number_format($completedRevenue, 0, ',', '.') }}đ</p>
                            </div>
                            <i class="fas fa-check-double text-emerald-400 text-2xl"></i>
                        </div>
                    </div>

                    <div class="bg-yellow-50 rounded-lg p-4 border border-yellow-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Đơn hàng chưa hoàn thành</p>
                                <p class="text-xl font-bold text-yellow-600">{{ $orderStats['pending'] + $orderStats['processing'] + $orderStats['ordered'] }}</p>
                            </div>
                            <i class="fas fa-clock text-yellow-400 text-2xl"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <script>
        // Initialize Order Status Pie Chart
        const ctx = document.getElementById('orderStatusChart');
        if (ctx) {
            const orderStatusChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['Chờ xử lý', 'Đang xử lý', 'Đã đặt hàng', 'Hoàn thành', 'Đã hủy'],
                    datasets: [{
                        data: [
                            {{ $orderStats['pending'] }},
                            {{ $orderStats['processing'] }},
                            {{ $orderStats['ordered'] }},
                            {{ $orderStats['completed'] }},
                            {{ $orderStats['cancelled'] }}
                        ],
                        backgroundColor: [
                            'rgb(234, 179, 8)',  // yellow-500
                            'rgb(59, 130, 246)',  // blue-500
                            'rgb(34, 197, 94)',   // green-500
                            'rgb(16, 185, 129)',  // emerald-500
                            'rgb(239, 68, 68)'    // red-500
                        ],
                        borderColor: [
                            'rgb(202, 138, 4)',
                            'rgb(37, 99, 235)',
                            'rgb(22, 163, 74)',
                            'rgb(5, 150, 105)',
                            'rgb(220, 38, 38)'
                        ],
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 15,
                                font: {
                                    size: 12
                                },
                                usePointStyle: true,
                                pointStyle: 'circle'
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.parsed || 0;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                    return ` ${label}: ${value} đơn (${percentage}%)`;
                                }
                            },
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            padding: 12,
                            cornerRadius: 8,
                            titleFont: {
                                size: 14,
                                weight: 'bold'
                            },
                            bodyFont: {
                                size: 13
                            }
                        }
                    }
                }
            });
        }
    </script>
</body>
</html>
