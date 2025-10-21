<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết giỏ hàng #{{ $order->id }}</title>
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
                                <a href="{{ route('orders.index') }}" class="pizza-nav-link">Giỏ hàng của tôi</a>
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
            <!-- Header giỏ hàng -->
            <div class="order-header">
                <h1>Chi tiết giỏ hàng #{{ $order->id }}</h1>
                <div class="order-status status-{{ $order->status }}">
                    @php
                        $statusLabels = [
                            'pending' => 'Đang xử lý',
                            'ordered' => 'Đã đặt hàng',
                            'processing' => 'Đang xử lý',
                            'completed' => 'Hoàn thành',
                            'cancelled' => 'Đã hủy',
                        ];
                        $statusText = $statusLabels[$order->status] ?? $order->status_text;
                    @endphp
                    {{ $statusText }}
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

            <!-- Chi tiết sản phẩm & Tổng tiền (two-column) -->
            <div class="order-section">
                <div class="order-two-col">
                    <div class="order-summary-col">
                        <h3>Tổng thanh toán</h3>
                        <div class="order-summary compact">
                            <div class="summary-row">
                                <span class="label">Tạm tính:</span>
                                <span class="value">{{ number_format($order->subtotal, 0, ',', '.') }}₫</span>
                            </div>
                            <div class="summary-row">
                                <span class="label">Giảm giá:</span>
                                <span class="value" id="order-discount">{{ number_format($order->discount_amount ?? 0, 0, ',', '.') }}₫</span>
                            </div>
                            <!-- Coupon apply panel -->
                            <div class="summary-row coupon-row" style="align-items:center; gap:10px;">
                                @if($order->coupon_id)
                                    <div style="flex:1">
                                        <strong>Mã giảm giá:</strong> <span id="applied-coupon">{{ $order->coupon_code }}</span>
                                    </div>
                                    <form method="POST" action="{{ route('orders.coupon.remove', $order->id) }}" style="display:inline">
                                        @csrf
                                        @method('DELETE')
                                            <button type="submit" class="btn btn-small btn-danger">Xóa</button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('orders.coupon.apply', $order->id) }}" id="apply-coupon-form" style="display:flex; flex:1; gap:8px; align-items:center;">
                                        @csrf
                                        <input type="text" name="coupon_code" id="coupon_code" placeholder="Nhập mã giảm giá" style="padding:8px; flex:1; border-radius:6px; border:1px solid #e6e6e6;" value="">
                                        <button type="submit" style="padding:6px 10px; border-radius:6px; background:#28a745; color:#fff; font-weight:600; border:none; cursor:pointer; font-size:0.9rem;">Áp dụng</button>
                                    </form>
                                @endif
                            </div>
                            <div class="summary-row total">
                                <span class="label">Tổng:</span>
                                <span class="value">{{ number_format($order->total, 0, ',', '.') }}₫</span>
                            </div>
                        </div>
                    </div>

                    <div class="order-main-col">
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
                                @if(in_array($order->status, ['pending','processing']))
                                    <form id="update-item-{{ $item->id }}" action="{{ route('orders.items.update', ['order' => $order->id, 'item' => $item->id]) }}" method="POST" style="display:none;">
                                        @csrf
                                        @method('PATCH')
                                    </form>
                                @endif

                                <tr>
                                    <td class="product-name">{{ $item->pizza_name }}</td>
                                    <td class="product-size">
                                        @if(in_array($order->status, ['pending','processing']))
                                            <select name="pizza_size" form="update-item-{{ $item->id }}" class="px-2 py-1 border rounded-md text-sm">
                                                <option value="small" {{ ($item->pizza_size ?? '') === 'small' ? 'selected' : '' }}>Small</option>
                                                <option value="medium" {{ ($item->pizza_size ?? '') === 'medium' ? 'selected' : '' }}>Medium</option>
                                                <option value="large" {{ ($item->pizza_size ?? '') === 'large' ? 'selected' : '' }}>Large</option>
                                            </select>
                                        @else
                                            {{ $item->size_text }}
                                        @endif
                                    </td>
                                    <td class="product-quantity">
                                        @if(in_array($order->status, ['pending','processing']))
                                            <input type="number" name="quantity" form="update-item-{{ $item->id }}" value="{{ $item->quantity }}" min="1" class="w-20 px-2 py-1 border rounded-md text-sm" />
                                        @else
                                            {{ $item->quantity }}
                                        @endif
                                    </td>
                                    <td class="product-price">{{ number_format($item->unit_price, 0, ',', '.') }}₫</td>
                                    <td class="product-total">{{ number_format($item->total_price, 0, ',', '.') }}₫</td>
                                    <td style="min-width:200px; text-align:center;">
                                        @if(in_array($order->status, ['pending','processing']))
                                            <div style="display:flex; gap:8px; justify-content:center; align-items:center;">
                                                <button form="update-item-{{ $item->id }}" type="submit" style="padding:8px 12px; background:#ff6b35; color:white; border:none; border-radius:8px; font-weight:600; cursor:pointer; width:85px; height:38px; box-shadow:0 2px 8px rgba(0,0,0,0.15); transition:all 0.2s; font-size:14px;">Cập nhật</button>

                                                <form method="POST" action="{{ route('orders.items.delete', ['order' => $order->id, 'item' => $item->id]) }}" style="display:inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" style="padding:8px 12px; background:#dc3545; color:white; border:none; border-radius:8px; font-weight:600; cursor:pointer; width:85px; height:38px; box-shadow:0 2px 8px rgba(0,0,0,0.15); transition:all 0.2s; font-size:14px;" onclick="return confirm('Bạn có chắc muốn xóa món này?')">Xóa</button>
                                                </form>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                        @if(in_array($order->status, ['pending','processing']))
                        <div style="margin-top:20px;">
                            <h4>Thêm món vào giỏ hàng</h4>
                            <form method="POST" action="{{ route('orders.items.add', $order->id) }}" id="add-item-form">
                                @csrf
                                <div style="display:flex; gap:10px; align-items:center; margin-top:10px;">
                                    <select name="pizza_id" id="add-pizza-id" style="padding:8px; border-radius:6px; border:1px solid #e6e6e6;">
                                        @foreach($pizzas as $p)
                                            <option value="{{ $p->id }}" data-price="{{ $p->price }}">{{ $p->name }} - {{ number_format($p->price,0,',','.') }}₫</option>
                                        @endforeach
                                    </select>

                                    <select name="pizza_size" id="add-pizza-size" style="padding:8px; border-radius:6px; border:1px solid #e6e6e6;">
                                        <option value="small">Small</option>
                                        <option value="medium">Medium</option>
                                        <option value="large">Large</option>
                                    </select>

                                    <input type="number" name="quantity" id="add-quantity" value="1" min="1" style="width:80px;padding:8px; border-radius:6px; border:1px solid #e6e6e6;">

                                    <div id="add-item-price" style="font-weight:700;">0₫</div>

                                    <button type="submit" style="padding:8px 12px; background:#ff6b35; color:white; border:none; border-radius:8px; font-weight:600; cursor:pointer; width:85px; height:38px; box-shadow:0 2px 8px rgba(0,0,0,0.15); transition:all 0.2s; font-size:14px;">Cập nhật</button>
                                </div>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <!-- end two-column -->

            <!-- Actions -->
            <div class="order-actions flex items-center gap-4 justify-center mt-8">
                @if(in_array($order->status, ['pending','processing']))
                <form method="POST" action="{{ route('orders.update', $order->id) }}" style="display:inline-block;">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="action" value="place">
                    <button type="submit" style="padding:8px 12px; background:#28a745; color:white; border:none; border-radius:8px; font-weight:600; cursor:pointer; width:85px; height:38px; box-shadow:0 2px 8px rgba(0,0,0,0.15); transition:all 0.2s; font-size:14px;">
                        Đặt hàng
                    </button>
                </form>
                
                <form method="POST" action="{{ route('orders.update', $order->id) }}" style="display:inline-block;">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="action" value="cancel">
                    <button type="submit" style="padding:8px 12px; background:#dc3545; color:white; border:none; border-radius:8px; font-weight:600; cursor:pointer; width:85px; height:38px; box-shadow:0 2px 8px rgba(0,0,0,0.15); transition:all 0.2s; font-size:14px;" onclick="return confirm('Bạn có chắc muốn hủy giỏ hàng này?')">
                        Hủy
                    </button>
                </form>
                @endif

                     <a href="{{ route('orders.index') }}" style="padding:8px 12px; background:#6c757d; color:white; border:none; border-radius:8px; font-weight:600; cursor:pointer; width:85px; height:38px; box-shadow:0 2px 8px rgba(0,0,0,0.15); transition:all 0.2s; font-size:14px; display:inline-flex; align-items:center; justify-content:center; text-decoration:none;">
                    Quay lại
                </a>
            </div>
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

        /* two-column layout */
        .order-two-col {
            display: grid;
            grid-template-columns: 320px 1fr;
            gap: 24px;
            align-items: start;
        }

        .order-summary-col {
            position: sticky;
            top: 120px;
        }

        .order-summary.compact {
            background: #fff;
            padding: 18px;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.06);
            width: 100%;
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
            padding: 10px 18px;
                        <tr class="order-view-row">
                            <td class="product-name">{{ $item->pizza_name }}</td>
                            <td class="product-size">{{ $item->size_text }}</td>
                            <td class="product-quantity">{{ $item->quantity }}</td>
                            <td class="product-price">{{ number_format($item->unit_price, 0, ',', '.') }}₫</td>
                            <td class="product-total">{{ number_format($item->total_price, 0, ',', '.') }}₫</td>
                        </tr>
                        <!-- Inline edit row removed as requested -->
            background: #c82333;
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .order-header {
                flex-direction: column;
                text-align: center;
                gap: 15px;
            }

            .order-two-col {
                grid-template-columns: 1fr;
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
    <script src="{{ asset('js/order-add-item.js') }}"></script>
    <script>
        // AJAX update item without page reload
        document.addEventListener('DOMContentLoaded', function() {
            const updateForms = document.querySelectorAll('form[id^="update-item-"]');
            
            updateForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const formData = new FormData(form);
                    const itemId = form.id.replace('update-item-', '');
                    
                    fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            // Update displayed values - find by following sibling tr
                            const nextRow = form.nextElementSibling;
                            if (nextRow && nextRow.tagName === 'TR') {
                                const priceCell = nextRow.querySelector('.product-price');
                                const totalCell = nextRow.querySelector('.product-total');
                                
                                if (priceCell) {
                                    priceCell.textContent = new Intl.NumberFormat('vi-VN').format(Math.round(data.item.unit_price)) + '₫';
                                }
                                if (totalCell) {
                                    totalCell.textContent = new Intl.NumberFormat('vi-VN').format(Math.round(data.item.total_price)) + '₫';
                                }
                            }
                            
                            // Update order totals in summary
                            const summaryRows = document.querySelectorAll('.summary-row');
                            if (summaryRows.length >= 1) {
                                // First row is subtotal
                                const subtotalValue = summaryRows[0].querySelector('.value');
                                if (subtotalValue) {
                                    subtotalValue.textContent = new Intl.NumberFormat('vi-VN').format(Math.round(data.order.subtotal)) + '₫';
                                }
                            }
                            
                            // Find total row (has .total class)
                            const totalRow = document.querySelector('.summary-row.total .value');
                            if (totalRow) {
                                totalRow.textContent = new Intl.NumberFormat('vi-VN').format(Math.round(data.order.total)) + '₫';
                            }
                            
                            // Show toast notification
                            const toast = document.createElement('div');
                            toast.style.cssText = `
                                position: fixed;
                                top: 20px;
                                right: 20px;
                                background: #28a745;
                                color: white;
                                padding: 15px 25px;
                                border-radius: 8px;
                                box-shadow: 0 4px 12px rgba(0,0,0,0.3);
                                z-index: 10000;
                                font-weight: 600;
                                font-size: 16px;
                            `;
                            toast.textContent = '✓ Cập nhật thành công!';
                            document.body.appendChild(toast);
                            setTimeout(() => toast.remove(), 3000);
                            
                            // Show brief success indicator
                            const button = form.querySelector('button[type="submit"]');
                            if (button) {
                                const originalText = button.textContent;
                                button.textContent = '✓ Đã lưu';
                                button.style.background = '#28a745';
                                setTimeout(() => {
                                    button.textContent = originalText;
                                    button.style.background = '#ff6b35';
                                }, 1500);
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        
                        // Show error toast
                        const toast = document.createElement('div');
                        toast.style.cssText = `
                            position: fixed;
                            top: 20px;
                            right: 20px;
                            background: #dc3545;
                            color: white;
                            padding: 15px 25px;
                            border-radius: 8px;
                            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
                            z-index: 10000;
                            font-weight: 600;
                            font-size: 16px;
                        `;
                        toast.textContent = '✗ Có lỗi xảy ra khi cập nhật!';
                        document.body.appendChild(toast);
                        setTimeout(() => toast.remove(), 3000);
                    });
                });
            });
        });
    </script>
</body>
</html>