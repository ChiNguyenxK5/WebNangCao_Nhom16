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

    @include('admin.partials.sidebar')

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
                <div class="flex justify-center items-center" style="height: 280px;">
                    <canvas id="orderStatusChart"></canvas>
                </div>
            </div>

            {{-- Revenue Summary --}}
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <i class="fas fa-money-bill-wave text-green-600"></i>
                    Tổng quan doanh thu
                </h2>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg p-4 border border-green-200">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-gray-700 font-medium text-sm">Tổng doanh thu</span>
                            <i class="fas fa-chart-line text-green-600"></i>
                        </div>
                        <p class="text-2xl font-bold text-green-600">{{ number_format($totalRevenue, 0, ',', '.') }}đ</p>
                        <p class="text-xs text-gray-600 mt-1">Từ {{ $totalOrders }} đơn hàng</p>
                    </div>

                    @php
                        $avgOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;
                        $completedRevenue = \App\Models\Order::where('status', 'completed')->sum('total');
                    @endphp

                    <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-gray-700 font-medium text-sm">Giá trị TB/đơn</span>
                            <i class="fas fa-calculator text-blue-600"></i>
                        </div>
                        <p class="text-2xl font-bold text-blue-600">{{ number_format($avgOrderValue, 0, ',', '.') }}đ</p>
                        <p class="text-xs text-gray-600 mt-1">Trung bình mỗi đơn</p>
                    </div>

                    <div class="bg-emerald-50 rounded-lg p-4 border border-emerald-200">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-gray-700 font-medium text-sm">DT đơn hoàn thành</span>
                            <i class="fas fa-check-double text-emerald-600"></i>
                        </div>
                        <p class="text-2xl font-bold text-emerald-600">{{ number_format($completedRevenue, 0, ',', '.') }}đ</p>
                        <p class="text-xs text-gray-600 mt-1">{{ $orderStats['completed'] }} đơn</p>
                    </div>

                    <div class="bg-yellow-50 rounded-lg p-4 border border-yellow-200">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-gray-700 font-medium text-sm">Đơn chưa hoàn thành</span>
                            <i class="fas fa-clock text-yellow-600"></i>
                        </div>
                        <p class="text-2xl font-bold text-yellow-600">{{ $orderStats['pending'] + $orderStats['processing'] }}</p>
                        <p class="text-xs text-gray-600 mt-1">Chưa hoàn thành</p>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <script>
        // Initialize Order Status Doughnut Chart with beautiful design
        const ctx = document.getElementById('orderStatusChart');
        if (ctx) {
            // Create gradient backgrounds for each segment
            const createGradient = (ctx, color1, color2) => {
                const gradient = ctx.createLinearGradient(0, 0, 0, 400);
                gradient.addColorStop(0, color1);
                gradient.addColorStop(1, color2);
                return gradient;
            };

            const chartCtx = ctx.getContext('2d');
            
            const orderStatusChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Chờ xử lý', 'Đang xử lý', 'Hoàn thành', 'Đã hủy'],
                    datasets: [{
                        data: [
                            {{ $orderStats['pending'] }},
                            {{ $orderStats['processing'] }},
                            {{ $orderStats['completed'] }},
                            {{ $orderStats['cancelled'] }}
                        ],
                        backgroundColor: [
                            createGradient(chartCtx, 'rgba(251, 191, 36, 0.9)', 'rgba(245, 158, 11, 0.9)'),   // yellow gradient
                            createGradient(chartCtx, 'rgba(96, 165, 250, 0.9)', 'rgba(59, 130, 246, 0.9)'),   // blue gradient
                            createGradient(chartCtx, 'rgba(52, 211, 153, 0.9)', 'rgba(16, 185, 129, 0.9)'),   // emerald gradient
                            createGradient(chartCtx, 'rgba(248, 113, 113, 0.9)', 'rgba(239, 68, 68, 0.9)')    // red gradient
                        ],
                        borderColor: '#ffffff',
                        borderWidth: 4,
                        hoverOffset: 15,
                        hoverBorderWidth: 4,
                        hoverBorderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '65%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                font: {
                                    size: 13,
                                    weight: '500',
                                    family: "'Inter', sans-serif"
                                },
                                usePointStyle: true,
                                pointStyle: 'circle',
                                boxWidth: 10,
                                boxHeight: 10,
                                color: '#374151',
                                generateLabels: function(chart) {
                                    const data = chart.data;
                                    if (data.labels.length && data.datasets.length) {
                                        return data.labels.map((label, i) => {
                                            const meta = chart.getDatasetMeta(0);
                                            const value = data.datasets[0].data[i];
                                            const total = data.datasets[0].data.reduce((a, b) => a + b, 0);
                                            const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                            
                                            // Lấy màu solid cho legend
                                            const colors = [
                                                'rgb(251, 191, 36)',  // yellow
                                                'rgb(59, 130, 246)',  // blue
                                                'rgb(16, 185, 129)',  // emerald
                                                'rgb(239, 68, 68)'    // red
                                            ];
                                            
                                            return {
                                                text: `${label}: ${value} (${percentage}%)`,
                                                fillStyle: colors[i],
                                                strokeStyle: colors[i],
                                                lineWidth: 2,
                                                hidden: meta.data[i].hidden,
                                                index: i
                                            };
                                        });
                                    }
                                    return [];
                                }
                            },
                            onClick: function(e, legendItem, legend) {
                                const index = legendItem.index;
                                const chart = legend.chart;
                                const meta = chart.getDatasetMeta(0);
                                
                                // Toggle visibility
                                meta.data[index].hidden = !meta.data[index].hidden;
                                
                                // Update chart
                                chart.update();
                            }
                        },
                        tooltip: {
                            enabled: true,
                            backgroundColor: 'rgba(0, 0, 0, 0.85)',
                            padding: 16,
                            cornerRadius: 12,
                            titleFont: {
                                size: 15,
                                weight: 'bold',
                                family: "'Inter', sans-serif"
                            },
                            bodyFont: {
                                size: 14,
                                family: "'Inter', sans-serif"
                            },
                            bodySpacing: 8,
                            displayColors: true,
                            boxWidth: 12,
                            boxHeight: 12,
                            boxPadding: 6,
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.parsed || 0;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                    return ` ${label}: ${value} đơn (${percentage}%)`;
                                }
                            }
                        }
                    },
                    animation: {
                        animateRotate: true,
                        animateScale: true,
                        duration: 1500,
                        easing: 'easeInOutQuart'
                    },
                    interaction: {
                        mode: 'nearest',
                        intersect: true
                    }
                },
                plugins: [{
                    // Custom plugin to draw text in center
                    id: 'centerText',
                    beforeDraw: function(chart) {
                        const ctx = chart.ctx;
                        const chartArea = chart.chartArea;
                        const width = chart.width;
                        const height = chart.height;
                        const total = chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                        
                        ctx.save();
                        
                        // Calculate center of the doughnut (chartArea center)
                        const centerX = (chartArea.left + chartArea.right) / 2;
                        const centerY = (chartArea.top + chartArea.bottom) / 2;
                        
                        // Main number
                        const fontSize = Math.round(height / 8);
                        ctx.font = `bold ${fontSize}px Inter, sans-serif`;
                        ctx.textBaseline = 'middle';
                        ctx.textAlign = 'center';
                        ctx.fillStyle = '#1f2937';
                        
                        const text = total.toString();
                        ctx.fillText(text, centerX, centerY - 10);
                        
                        // Subtitle
                        const subtitleFontSize = Math.round(fontSize * 0.35);
                        ctx.font = `500 ${subtitleFontSize}px Inter, sans-serif`;
                        ctx.fillStyle = '#6b7280';
                        const subtitle = 'Tổng đơn hàng';
                        ctx.fillText(subtitle, centerX, centerY + 20);
                        
                        ctx.restore();
                    }
                }]
            });

            // Add hover animation effect
            ctx.onclick = function(evt) {
                const activePoints = orderStatusChart.getElementsAtEventForMode(evt, 'nearest', { intersect: true }, false);
                if (activePoints.length > 0) {
                    // Add ripple effect or other interactions here if needed
                }
            };
        }
    </script>
</body>
</html>
