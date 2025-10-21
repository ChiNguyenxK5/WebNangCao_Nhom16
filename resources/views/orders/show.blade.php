@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-semibold mb-4">Chi tiết giỏ hàng #{{ $order->id }}</h1>

    <div class="bg-white p-6 rounded shadow">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p><strong>Khách hàng:</strong> {{ $order->user->name ?? 'Khách' }}</p>
                <p><strong>Trạng thái:</strong> {{ ucfirst($order->status) }}</p>
                <p><strong>Địa chỉ:</strong> {{ $order->shipping_address }}</p>
                <p><strong>Điện thoại:</strong> {{ $order->phone }}</p>
            </div>
            <div>
                <p><strong>Ngày tạo:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                @if($order->notes)
                    <p><strong>Ghi chú:</strong> {{ $order->notes }}</p>
                @endif
            </div>
        </div>

        <h2 class="mt-6 mb-2 text-lg font-semibold">Sản phẩm</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Sản phẩm</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Kích thước</th>
                        <th class="px-4 py-2 text-right text-sm font-medium text-gray-500">Số lượng</th>
                        <th class="px-4 py-2 text-right text-sm font-medium text-gray-500">Giá đơn vị</th>
                        <th class="px-4 py-2 text-right text-sm font-medium text-gray-500">Tổng</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($order->items as $item)
                        <tr>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    @if(optional($item->pizza)->image_url)
                                        <img src="{{ asset(optional($item->pizza)->image_url) }}" alt="{{ $item->pizza_name }}" class="w-16 h-16 object-cover rounded">
                                    @endif
                                    <div>
                                        <div class="font-medium">{{ $item->pizza_name }}</div>
                                        @if(optional($item->pizza))
                                            <div class="text-sm text-gray-500">{{ $item->pizza->topping ?? '' }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3">{{ ucfirst($item->pizza_size ?? 'medium') }}</td>
                            <td class="px-4 py-3 text-right">{{ $item->quantity }}</td>
                            <td class="px-4 py-3 text-right">{{ number_format($item->unit_price, 0, ',', '.') }} ₫</td>
                            <td class="px-4 py-3 text-right font-semibold">{{ number_format($item->total_price, 0, ',', '.') }} ₫</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-4 text-center text-gray-500">Không có sản phẩm trong giỏ hàng.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6 flex justify-end">
            <div class="w-full max-w-md">
                <div class="flex justify-between py-2">
                    <span class="text-gray-600">Tạm tính</span>
                    <span class="font-medium">{{ number_format($order->subtotal ?? 0, 0, ',', '.') }} ₫</span>
                </div>
                <div class="flex justify-between py-2">
                    <span class="text-gray-600">Giảm giá</span>
                    <span class="font-medium">{{ number_format($order->discount_amount ?? 0, 0, ',', '.') }} ₫</span>
                </div>
                <div class="border-t mt-2 pt-3 flex justify-between text-xl font-bold">
                    <span>Tổng thanh toán</span>
                    <span>{{ number_format($order->total ?? 0, 0, ',', '.') }} ₫</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
