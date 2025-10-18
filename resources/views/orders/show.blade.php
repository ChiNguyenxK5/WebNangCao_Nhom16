@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-semibold mb-4">Chi tiết đơn hàng #{{ $order->id }}</h1>

    <div class="bg-white p-4 rounded shadow">
        <p><strong>Khách hàng:</strong> {{ $order->user->name ?? 'Khách' }}</p>
        <p><strong>Trạng thái:</strong> {{ $order->status }}</p>
        <p><strong>Địa chỉ:</strong> {{ $order->shipping_address }}</p>
        <p><strong>Điện thoại:</strong> {{ $order->phone }}</p>
        <p><strong>Ghi chú:</strong> {{ $order->notes }}</p>

        <h2 class="mt-4 font-semibold">Sản phẩm</h2>
        <table class="w-full mt-2 table-auto">
            <thead>
                <tr class="text-left">
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
                    <td>{{ $item->pizza_name }}</td>
                    <td>{{ $item->pizza_size }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->unit_price, 2) }}</td>
                    <td>{{ number_format($item->total_price, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4 text-right">
            <p class="font-semibold">Tạm tính: {{ number_format($order->subtotal, 2) }} ₫</p>
            <p class="font-semibold">Giảm giá: {{ number_format($order->discount_amount ?? 0, 2) }} ₫</p>
            <p class="text-xl font-bold">Tổng: {{ number_format($order->total, 2) }} ₫</p>
        </div>
    </div>
</div>
@endsection
