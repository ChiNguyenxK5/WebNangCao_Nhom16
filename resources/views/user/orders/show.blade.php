<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết đơn hàng #{{ $order->id }}</title>
    @vite(['resources/css/app.css'])
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-inline.css') }}">
</head>

<body>
    <!-- Header -->
    <header class="pizza-header">
        <div class="container">
            <div class="pizza-navbar">
                <div class="pizza-logo-section">
                    <div class="pizza-logo">
                        <span class="pizza-icon">🍕</span>
                        <img src="{{ asset('uploads/logopizza (1).png') }}" alt="Pizza Store" class="logo-img">
                    </div>
                </div>
                
                <div class="pizza-nav-menu">
                    <nav>
                        <ul class="pizza-nav-links">
                            <li class="pizza-nav-item">
                                <a href="{{ url('/') }}" class="pizza-nav-link">Trang chủ</a>
                            </li>
                            <li class="pizza-nav-item">
                                <a href="{{ route('orders.index') }}" class="pizza-nav-link">Đơn hàng của tôi</a>
                            </li>
                        </ul>
                    </nav>
                </div>

                @auth
                <div class="pizza-user-section">
                    <div class="pizza-user-profile">
                        <div class="pizza-user-avatar">
                            <span class="avatar-text">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                        </div>
                        <div class="pizza-user-info">
                            <span class="user-name">{{ auth()->user()->name }}</span>
                        </div>
                    </div>
                </div>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="order-detail-container">
        <div class="container">
            <!-- Header đơn hàng -->
            <div class="order-header">
                <h1>Chi tiết đơn hàng #{{ $order->id }}</h1>
                <div class="order-status status-{{ $order->status }}">
                    {{ $order->status_text }}
                </div>
            </div>

            <!-- Thông tin khách hàng -->
            <div class="order-section">
                <h3>Thông tin khách hàng</h3>
                <div class="customer-info">
                    <div class="info-row">
                        <span class="label">Khách hàng:</span>
                        <span class="value">{{ $order->user->name }}</span>
                    </div>
                    <div class="info-row">
                        <span class="label">Trạng thái:</span>
                        <span class="value status-{{ $order->status }}">{{ $order->status_text }}</span>
                    </div>
                    <div class="info-row">
                        <span class="label">Địa chỉ:</span>
                        <span class="value">{{ $order->shipping_address ?: 'Chưa cập nhật' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="label">Điện thoại:</span>
                        <span class="value">{{ $order->phone ?: 'Chưa cập nhật' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="label">Ghi chú:</span>
                        <span class="value">{{ $order->notes ?: 'Không có' }}</span>
                    </div>
                </div>
            </div>

            <!-- Chi tiết sản phẩm -->
            <div class="order-section">
                <h3>Sản phẩm</h3>
                <div class="order-items">
                    <table class="items-table">
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Kích thước</th>
                                <th>Số lượng</th>
                                <th>Giá</th>
                                <th>Tổng</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td class="product-name">{{ $item->pizza_name }}</td>
                                <td class="product-size">{{ $item->size_text }}</td>
                                <td class="product-quantity">{{ $item->quantity }}</td>
                                <td class="product-price">{{ number_format($item->unit_price, 0, ',', '.') }}₫</td>
                                <td class="product-total">{{ number_format($item->total_price, 0, ',', '.') }}₫</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tổng tiền -->
            <div class="order-section">
                <div class="order-summary">
                    <div class="summary-row">
                        <span class="label">Tạm tính:</span>
                        <span class="value">{{ number_format($order->subtotal, 0, ',', '.') }}₫</span>
                    </div>
                    <div class="summary-row">
                        <span class="label">Giảm giá:</span>
                        <span class="value">{{ number_format($order->discount_amount ?? 0, 0, ',', '.') }}₫</span>
                    </div>
                    <div class="summary-row total">
                        <span class="label">Tổng:</span>
                        <span class="value">{{ number_format($order->total, 0, ',', '.') }}₫</span>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="order-actions">
                <a href="{{ route('orders.index') }}" class="btn btn-secondary">
                    ← Quay lại đơn hàng của tôi
                </a>
                
                @if($order->status === 'pending')
                <form method="POST" action="{{ route('orders.update', $order->id) }}" style="display: inline;">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="action" value="cancel">
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc muốn hủy đơn hàng này?')">
                        Hủy đơn hàng
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>

    <style>
        .order-detail-container {
            min-height: 100vh;
            background: #f8f9fa;
            padding: 120px 0 60px 0;
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
            padding: 30px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .order-header h1 {
            margin: 0;
            color: #333;
            font-size: 2rem;
        }

        .order-status {
            padding: 10px 20px;
            border-radius: 25px;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.9rem;
        }

        .status-pending { background: #fff3cd; color: #856404; }
        .status-processing { background: #d1ecf1; color: #0c5460; }
        .status-completed { background: #d1e7dd; color: #0f5132; }
        .status-cancelled { background: #f8d7da; color: #721c24; }

        .order-section {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .order-section h3 {
            margin: 0 0 20px 0;
            color: #ff6b35;
            font-size: 1.4rem;
            border-bottom: 2px solid #ff6b35;
            padding-bottom: 10px;
        }

        .customer-info .info-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #eee;
        }

        .customer-info .info-row:last-child {
            border-bottom: none;
        }

        .customer-info .label {
            font-weight: 600;
            color: #666;
            min-width: 120px;
        }

        .customer-info .value {
            color: #333;
            flex: 1;
            text-align: right;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
        }

        .items-table th,
        .items-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .items-table th {
            background: #f8f9fa;
            font-weight: 600;
            color: #666;
        }

        .product-name {
            font-weight: 600;
            color: #333;
        }

        .product-size {
            color: #666;
        }

        .product-quantity,
        .product-price,
        .product-total {
            text-align: center;
        }

        .order-summary {
            max-width: 400px;
            margin-left: auto;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #eee;
        }

        .summary-row.total {
            border-top: 2px solid #ff6b35;
            border-bottom: none;
            font-weight: 700;
            font-size: 1.2rem;
            color: #ff6b35;
            margin-top: 10px;
            padding-top: 20px;
        }

        .order-actions {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 40px;
        }

        .btn {
            padding: 12px 25px;
            border: none;
            border-radius: 25px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background: #5a6268;
            transform: translateY(-2px);
        }

        .btn-danger {
            background: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background: #c82333;
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .order-header {
                flex-direction: column;
                text-align: center;
                gap: 15px;
            }

            .items-table {
                font-size: 0.9rem;
            }

            .items-table th,
            .items-table td {
                padding: 10px 5px;
            }

            .order-actions {
                flex-direction: column;
                align-items: center;
            }

            .btn {
                width: 100%;
                max-width: 300px;
            }
        }
    </style>
</body>
</html>