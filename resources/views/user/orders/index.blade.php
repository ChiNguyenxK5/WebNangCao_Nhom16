<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đơn hàng của tôi</title>
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
                                <a href="{{ route('orders.index') }}" class="pizza-nav-link active">Đơn hàng của tôi</a>
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
    <div class="orders-container">
        <div class="container">
            <h1>Đơn hàng của tôi</h1>
            
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            @if($orders->count() > 0)
                <div class="orders-list">
                    @foreach($orders as $order)
                    <div class="order-card">
                        <div class="order-card-header">
                            <div class="order-info">
                                <h3>Đơn hàng #{{ $order->id }}</h3>
                                <p class="order-date">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                            <div class="order-status status-{{ $order->status }}">
                                {{ $order->status_text }}
                            </div>
                        </div>
                        
                        <div class="order-card-body">
                            <div class="order-items">
                                @foreach($order->items as $item)
                                <div class="order-item">
                                    <span class="item-name">{{ $item->pizza_name }}</span>
                                    <span class="item-details">{{ $item->size_text }} x{{ $item->quantity }}</span>
                                </div>
                                @endforeach
                            </div>
                            
                            <div class="order-total">
                                <strong>{{ number_format($order->total, 0, ',', '.') }}₫</strong>
                            </div>
                        </div>
                        
                        <div class="order-card-actions">
                            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-primary">
                                Xem chi tiết
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="empty-orders">
                    <div class="empty-icon">🍕</div>
                    <h3>Không có đơn hàng nào</h3>
                    <p>Bạn chưa có đơn hàng nào hoặc đã hủy tất cả. Hãy đặt pizza ngay để thưởng thức những món ngon nhất!</p>
                    <a href="{{ url('/') }}" class="btn btn-primary">Đặt pizza ngay</a>
                </div>
            @endif
        </div>
    </div>

    <style>
        .orders-container {
            min-height: 100vh;
            background: #f8f9fa;
            padding: 120px 0 60px 0;
        }

        .orders-container h1 {
            text-align: center;
            margin-bottom: 40px;
            color: #333;
            font-size: 2.5rem;
        }

        .alert {
            max-width: 800px;
            margin: 0 auto 30px auto;
            padding: 15px 20px;
            border-radius: 8px;
            text-align: center;
            font-weight: 500;
        }

        .alert-success {
            background-color: #d1e7dd;
            color: #0f5132;
            border: 1px solid #badbcc;
        }

        .orders-list {
            max-width: 800px;
            margin: 0 auto;
        }

        .order-card {
            background: white;
            border-radius: 15px;
            margin-bottom: 20px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .order-card:hover {
            transform: translateY(-5px);
        }

        .order-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 25px;
            background: #f8f9fa;
            border-bottom: 1px solid #eee;
        }

        .order-info h3 {
            margin: 0;
            color: #333;
            font-size: 1.2rem;
        }

        .order-date {
            margin: 5px 0 0 0;
            color: #666;
            font-size: 0.9rem;
        }

        .order-status {
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: uppercase;
        }

        .status-pending { background: #fff3cd; color: #856404; }
        .status-processing { background: #d1ecf1; color: #0c5460; }
        .status-completed { background: #d1e7dd; color: #0f5132; }
        .status-cancelled { background: #f8d7da; color: #721c24; }

        .order-card-body {
            padding: 20px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .order-items {
            flex: 1;
        }

        .order-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .item-name {
            font-weight: 600;
            color: #333;
        }

        .item-details {
            color: #666;
            font-size: 0.9rem;
        }

        .order-total {
            font-size: 1.3rem;
            color: #ff6b35;
        }

        .order-card-actions {
            padding: 15px 25px;
            background: #f8f9fa;
            text-align: right;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 20px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .btn-primary {
            background: #ff6b35;
            color: white;
        }

        .btn-primary:hover {
            background: #e55a2e;
            transform: translateY(-2px);
        }

        .empty-orders {
            text-align: center;
            padding: 60px 20px;
            max-width: 500px;
            margin: 0 auto;
        }

        .empty-icon {
            font-size: 4rem;
            margin-bottom: 20px;
        }

        .empty-orders h3 {
            color: #333;
            margin-bottom: 15px;
        }

        .empty-orders p {
            color: #666;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        @media (max-width: 768px) {
            .orders-container {
                padding: 100px 15px 60px 15px;
            }

            .order-card-header {
                flex-direction: column;
                text-align: center;
                gap: 10px;
            }

            .order-card-body {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }

            .order-item {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>
</body>
</html>