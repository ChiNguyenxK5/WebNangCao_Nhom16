@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-semibold mb-4">Đặt hàng: {{ $pizza->name }}</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <img src="{{ $pizza->image_url }}" alt="{{ $pizza->name }}" class="w-full rounded shadow">
            <p class="mt-3">{{ $pizza->description }}</p>
            <p class="mt-2 font-bold">Giá cơ bản: {{ number_format($pizza->price, 2) }} ₫</p>
        </div>

        <div>
            <form action="{{ route('orders.store') }}" method="POST">
                @csrf
                <input type="hidden" name="pizza_id" value="{{ $pizza->id }}">

                <div class="mb-3">
                    <label class="block font-medium">Kích thước</label>
                    <select name="pizza_size" class="w-full border rounded p-2">
                        <option value="small">Small</option>
                        <option value="medium">Medium</option>
                        <option value="large">Large</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="block font-medium">Số lượng</label>
                    <input type="number" name="quantity" value="1" min="1" class="w-full border rounded p-2">
                </div>

                <div class="mb-3">
                    <label class="block font-medium">Địa chỉ giao hàng</label>
                    <textarea name="shipping_address" rows="3" class="w-full border rounded p-2">{{ old('shipping_address') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="block font-medium">Số điện thoại</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" class="w-full border rounded p-2">
                </div>

                <div class="mb-3">
                    <label class="block font-medium">Ghi chú (tùy chọn)</label>
                    <textarea name="notes" rows="2" class="w-full border rounded p-2">{{ old('notes') }}</textarea>
                </div>

                <div class="mt-4">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Đặt hàng</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-bold mb-4">Đặt hàng {{ $pizza->name }}</h2>
                    
                    <form method="POST" action="{{ route('orders.store') }}">
                        @csrf
                        <input type="hidden" name="pizza_id" value="{{ $pizza->id }}">
                        
                        <div class="mb-4">
                            <label class="block text-gray-700">Tên của bạn</label>
                            <input type="text" name="customer_name" required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700">Số điện thoại</label>
                            <input type="tel" name="phone" required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700">Địa chỉ</label>
                            <textarea name="address" required
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700">Số lượng</label>
                            <input type="number" name="quantity" min="1" value="1" required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700">Ghi chú</label>
                            <textarea name="note"
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                        </div>

                        <div class="mt-6">
                            <button type="submit" 
                                    class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                                Đặt hàng
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
