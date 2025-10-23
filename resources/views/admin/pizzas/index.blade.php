<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Quản lý Pizza - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet" />
</head>

<body class="bg-gray-50 text-gray-900 flex min-h-screen">

    @include('admin.partials.sidebar')

    {{-- Nội dung chính --}}
    <main class="flex-1 p-6">
        <div class="mb-4 text-sm text-gray-600">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-indigo-600">Tổng quan</a> /
            <span class="text-indigo-600">{{ request()->routeIs('admin.orders.index') ? 'Quản lý đơn hàng' : 'Quản lý Pizza' }}</span>
        </div>

        @if(request()->routeIs('admin.orders.index'))
            {{-- Quản lý đơn hàng --}}
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900 flex items-center gap-3 mb-1">
                        <i class="fas fa-shopping-cart text-indigo-600"></i> Quản lý đơn hàng
                    </h1>
                    <p class="text-gray-600">Quản lý tất cả đơn hàng của khách hàng</p>
                </div>
            </div>
        @else
            {{-- Quản lý Pizza --}}
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900 flex items-center gap-3 mb-1">
                        <i class="fas fa-pizza-slice text-indigo-600"></i> Quản lý Pizza
                    </h1>
                    <p class="text-gray-600">Quản lý danh sách sản phẩm pizza của cửa hàng</p>
                </div>
                
                <button onclick="document.getElementById('addPizzaModal').classList.remove('hidden')"
                    class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 flex items-center gap-2 shadow-sm transition-colors">
                    <i class="fas fa-plus"></i> Thêm Pizza Mới
                </button>
            </div>
        @endif

        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-green-400"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if(!request()->routeIs('admin.orders.index'))
        {{-- Modal thêm pizza --}}
        <div id="addPizzaModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-md max-h-[90vh] flex flex-col">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                        <i class="fas fa-plus-circle text-indigo-600"></i>
                        Thêm Pizza Mới
                    </h3>
                </div>
                
                <form action="{{ route('admin.pizzas.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col flex-1 overflow-hidden">
                    @csrf
                    <div class="p-6 overflow-y-auto flex-1">
                        <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tên Pizza *</label>
                            <input type="text" name="name" placeholder="Nhập tên pizza..." 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" required>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Mô tả</label>
                            <textarea name="description" placeholder="Mô tả chi tiết về pizza..." rows="3"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"></textarea>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Giá *</label>
                                <input type="number" name="price" placeholder="0" step="1000" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Size</label>
                                <select name="size" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                    <option value="">Chọn size</option>
                                    <option value="S">Size S</option>
                                    <option value="M">Size M</option>
                                    <option value="L">Size L</option>
                                </select>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Ảnh Pizza</label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                <div class="space-y-1 text-center">
                                    <i class="fas fa-cloud-upload-alt text-3xl text-gray-400"></i>
                                    <div class="flex text-sm text-gray-600">
                                        <label class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500">
                                            <span>Chọn ảnh</span>
                                            <input type="file" name="image" accept="image/*" class="sr-only">
                                        </label>
                                        <p class="pl-1">hoặc kéo thả</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, GIF tối đa 2MB</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Đế pizza</label>
                                <input type="text" name="base" placeholder="VD: Đế mỏng, đế dày..." 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Loại pizza</label>
                                <input type="text" name="type" placeholder="VD: Hải sản, thịt..." 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Topping</label>
                            <input type="text" name="topping" placeholder="VD: Phô mai, thịt xông khói..." 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Sốt</label>
                            <input type="text" name="sauce" placeholder="VD: Sốt cà chua, sốt kem..." 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        </div>
                        
                        <div class="flex items-center">
                            <input type="checkbox" name="available" value="1" checked id="available" 
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="available" class="ml-2 block text-sm text-gray-900">Hiển thị cho khách hàng</label>
                        </div>
                        </div>
                    </div>
                    
                    <div class="flex justify-end gap-3 px-6 py-4 border-t border-gray-200 bg-gray-50">
                        <button type="button" onclick="document.getElementById('addPizzaModal').classList.add('hidden')" 
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Hủy
                        </button>
                        <button type="submit" 
                            class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <i class="fas fa-save mr-1"></i> Thêm Pizza
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @endif

        @if(request()->routeIs('admin.orders.index'))
            {{-- Bảng quản lý đơn hàng --}}
            <section class="bg-white border border-gray-200 rounded-lg shadow-sm mb-6">
                {{-- Status Filter Tabs --}}
                <div class="flex border-b">
                    <a href="{{ route('admin.orders.index') }}" 
                       class="px-6 py-4 text-center {{ !request('status') ? 'border-b-2 border-indigo-500 text-indigo-600 font-semibold' : 'text-gray-600 hover:text-gray-900' }}">
                        Tất cả ({{ $statusCounts['all'] }})
                    </a>
                    <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" 
                       class="px-6 py-4 text-center {{ request('status') == 'pending' ? 'border-b-2 border-indigo-500 text-indigo-600 font-semibold' : 'text-gray-600 hover:text-gray-900' }}">
                        Chờ xử lý ({{ $statusCounts['pending'] }})
                    </a>
                    <a href="{{ route('admin.orders.index', ['status' => 'processing']) }}" 
                       class="px-6 py-4 text-center {{ request('status') == 'processing' ? 'border-b-2 border-indigo-500 text-indigo-600 font-semibold' : 'text-gray-600 hover:text-gray-900' }}">
                        Đang xử lý ({{ $statusCounts['processing'] }})
                    </a>
                    <a href="{{ route('admin.orders.index', ['status' => 'completed']) }}" 
                       class="px-6 py-4 text-center {{ request('status') == 'completed' ? 'border-b-2 border-indigo-500 text-indigo-600 font-semibold' : 'text-gray-600 hover:text-gray-900' }}">
                        Hoàn thành ({{ $statusCounts['completed'] }})
                    </a>
                    <a href="{{ route('admin.orders.index', ['status' => 'cancelled']) }}" 
                       class="px-6 py-4 text-center {{ request('status') == 'cancelled' ? 'border-b-2 border-indigo-500 text-indigo-600 font-semibold' : 'text-gray-600 hover:text-gray-900' }}">
                        Đã hủy ({{ $statusCounts['cancelled'] }})
                    </a>
                </div>

                {{-- Search Form --}}
                <div class="p-4 bg-gray-50">
                    <form method="GET" action="{{ route('admin.orders.index') }}" class="flex gap-4">
                        @if(request('status'))
                            <input type="hidden" name="status" value="{{ request('status') }}">
                        @endif
                        <div class="flex-1">
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   placeholder="Tìm kiếm theo ID đơn hàng, tên khách hàng, email..." 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        </div>
                        <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
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

                {{-- Orders Table --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-gray-600 text-sm">
                        <thead class="border-b border-gray-200 bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 font-semibold text-gray-700 uppercase tracking-wide">ID</th>
                                <th class="px-6 py-4 font-semibold text-gray-700 uppercase tracking-wide">Khách hàng</th>
                                <th class="px-6 py-4 font-semibold text-gray-700 uppercase tracking-wide">Số lượng món</th>
                                <th class="px-6 py-4 font-semibold text-gray-700 uppercase tracking-wide">Tổng tiền</th>
                                <th class="px-6 py-4 font-semibold text-gray-700 uppercase tracking-wide">Trạng thái</th>
                                <th class="px-6 py-4 font-semibold text-gray-700 uppercase tracking-wide">Ngày tạo</th>
                                <th class="px-6 py-4 font-semibold text-gray-700 uppercase tracking-wide text-right">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                                <tr class="hover:bg-gray-50 border-b border-gray-100 transition-colors">
                                    <td class="px-6 py-4">
                                        <span class="font-medium text-gray-900">#{{ $order->id }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $order->user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $order->user->email }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-gray-900">{{ $order->items->sum('quantity') }} món</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="font-semibold text-gray-900">{{ number_format($order->total, 0, ',', '.') }}đ</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            $statusConfig = [
                                                'pending' => ['text' => 'Chờ xử lý', 'class' => 'bg-yellow-100 text-yellow-800'],
                                                'processing' => ['text' => 'Đang xử lý', 'class' => 'bg-blue-100 text-blue-800'],
                                                'completed' => ['text' => 'Hoàn thành', 'class' => 'bg-emerald-100 text-emerald-800'],
                                                'cancelled' => ['text' => 'Đã hủy', 'class' => 'bg-red-100 text-red-800'],
                                            ];
                                            $config = $statusConfig[$order->status] ?? ['text' => $order->status, 'class' => 'bg-gray-100 text-gray-800'];
                                        @endphp
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $config['class'] }}">
                                            {{ $config['text'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-500">
                                        {{ $order->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            @if($order->status !== 'cancelled' && $order->status !== 'completed')
                                                <form method="POST" action="{{ route('admin.orders.complete', $order) }}" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" 
                                                            onclick="return confirm('✅ Xác nhận hoàn thành đơn hàng #{{ $order->id }}?')"
                                                            class="inline-flex items-center gap-1 px-3 py-1.5 bg-gradient-to-r from-green-500 to-emerald-600 text-white text-sm font-medium rounded-lg hover:from-green-600 hover:to-emerald-700 shadow-sm hover:shadow-md transition-all duration-200 transform hover:scale-105">
                                                        <i class="fas fa-check-circle"></i>
                                                        <span>Hoàn thành</span>
                                                    </button>
                                                </form>
                                            @endif
                                            
                                            <button onclick="viewOrderDetail({{ $order->id }})" 
                                                    class="text-indigo-600 hover:text-indigo-900 font-medium">
                                                <i class="fas fa-eye mr-1"></i>Xem
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                        <i class="fas fa-inbox text-4xl mb-4 block"></i>
                                        <p class="text-lg">Không có đơn hàng nào</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($orders->hasPages())
                    <div class="px-6 py-4 border-t">
                        {{ $orders->links() }}
                    </div>
                @endif
            </section>
        @else
            {{-- Bảng quản lý pizza --}}
            <section class="bg-white border border-gray-200 rounded-lg shadow-sm">
                <header class="flex justify-between items-center px-6 py-4 border-b border-gray-200">
                    <h2 class="font-semibold text-gray-900 flex items-center gap-2">
                        <i class="fas fa-list"></i> Danh sách Pizza
                    </h2>
                    <span class="text-sm text-gray-500">Tổng cộng: {{ count($pizzas) }} pizza</span>
                </header>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-gray-600 text-sm">
                    <thead class="border-b border-gray-200 bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 font-semibold text-gray-700 uppercase tracking-wide">Mã</th>
                            <th class="px-6 py-4 font-semibold text-gray-700 uppercase tracking-wide">Pizza</th>
                            <th class="px-6 py-4 font-semibold text-gray-700 uppercase tracking-wide">Thông tin</th>
                            <th class="px-6 py-4 font-semibold text-gray-700 uppercase tracking-wide">Giá</th>
                            <th class="px-6 py-4 font-semibold text-gray-700 uppercase tracking-wide">Trạng thái</th>
                            <th class="px-6 py-4 font-semibold text-gray-700 uppercase tracking-wide text-right">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pizzas as $pizza)
                        <tr class="hover:bg-gray-50 border-b border-gray-100 transition-colors">
                            <td class="px-6 py-4">
                                <span class="font-medium text-gray-900">#{{ str_pad($pizza->id, 3, '0', STR_PAD_LEFT) }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-lg overflow-hidden bg-gray-100 flex-shrink-0">
                                        @if($pizza->image_url && file_exists(public_path($pizza->image_url)))
                                            <img src="{{ asset($pizza->image_url) }}" 
                                                 class="w-full h-full object-cover" alt="{{ $pizza->name }}">
                                        @else
                                            <img src="{{ asset('uploads/default-pizza.jpg') }}" 
                                                 class="w-full h-full object-cover" alt="{{ $pizza->name }}">
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $pizza->name }}</p>
                                        @if($pizza->size)
                                            <p class="text-sm text-gray-500">Size {{ $pizza->size }}</p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="max-w-xs">
                                    @if($pizza->description)
                                        <p class="text-gray-600 text-sm">{{ Str::limit($pizza->description, 60) }}</p>
                                    @endif
                                    @if($pizza->type || $pizza->base || $pizza->topping)
                                        <div class="flex flex-wrap gap-1 mt-1">
                                            @if($pizza->type)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                                    <i class="fas fa-pizza-slice mr-1"></i>{{ $pizza->type }}
                                                </span>
                                            @endif
                                            @if($pizza->base)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                                    {{ $pizza->base }}
                                                </span>
                                            @endif
                                            @if($pizza->size)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    Size {{ $pizza->size }}
                                                </span>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-gray-400 text-sm italic">Chưa phân loại</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-lg font-semibold text-gray-900">{{ number_format($pizza->price) }}₫</span>
                            </td>
                            <td class="px-6 py-4">
                                @if($pizza->available)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i> Đang bán
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <i class="fas fa-times-circle mr-1"></i> Đã ẩn
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center gap-2">
                                    {{-- Sửa --}}
                                    <button onclick="document.getElementById('editPizza{{ $pizza->id }}').classList.remove('hidden')" 
                                        class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                                        <i class="fas fa-edit mr-1"></i> Sửa
                                    </button>
                                    
                                    {{-- Xóa --}}
                                    <button onclick="deletePizza({{ $pizza->id }}, '{{ $pizza->name }}')" 
                                        class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                                        <i class="fas fa-trash mr-1"></i> Xóa
                                    </button>
                                    
                                    {{-- Hidden form for delete --}}
                                    <form id="delete-form-{{ $pizza->id }}" action="{{ route('admin.pizzas.destroy', $pizza->id) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>

                                {{-- Modal sửa --}}
                                <div id="editPizza{{ $pizza->id }}" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
                                    <div class="bg-white rounded-lg shadow-xl w-full max-w-md max-h-[90vh] flex flex-col">
                                        <div class="px-6 py-4 border-b border-gray-200">
                                            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                                                <i class="fas fa-edit text-indigo-600"></i>
                                                Chỉnh sửa Pizza: {{ $pizza->name }}
                                            </h3>
                                        </div>
                                        
                                        <form action="{{ route('admin.pizzas.update', $pizza->id) }}" method="POST" enctype="multipart/form-data" class="flex flex-col flex-1 overflow-hidden">
                                            @csrf
                                            @method('PUT')
                                            <div class="p-6 overflow-y-auto flex-1">
                                                <div class="space-y-4">
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">Tên Pizza *</label>
                                                    <input type="text" name="name" value="{{ $pizza->name }}" 
                                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" required>
                                                </div>
                                                
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">Mô tả</label>
                                                    <textarea name="description" rows="3"
                                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">{{ $pizza->description }}</textarea>
                                                </div>
                                                
                                                <div class="grid grid-cols-2 gap-4">
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 mb-1">Giá *</label>
                                                        <input type="number" name="price" value="{{ $pizza->price }}" step="1000" 
                                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" required>
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 mb-1">Size</label>
                                                        <select name="size" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                                            <option value="">Chọn size</option>
                                                            <option value="S" {{ $pizza->size == 'S' ? 'selected' : '' }}>Size S</option>
                                                            <option value="M" {{ $pizza->size == 'M' ? 'selected' : '' }}>Size M</option>
                                                            <option value="L" {{ $pizza->size == 'L' ? 'selected' : '' }}>Size L</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">Ảnh Pizza</label>
                                                    @if($pizza->image_url && file_exists(public_path($pizza->image_url)))
                                                        <div class="mb-3">
                                                            <img src="{{ asset($pizza->image_url) }}" class="w-24 h-24 object-cover rounded-lg border-2 border-gray-200" alt="Ảnh hiện tại">
                                                            <p class="text-sm text-gray-500 mt-1">Ảnh hiện tại</p>
                                                        </div>
                                                    @elseif($pizza->image_url)
                                                        <div class="mb-3">
                                                            <div class="w-24 h-24 bg-gray-200 rounded-lg border-2 border-gray-300 flex items-center justify-center">
                                                                <i class="fas fa-image text-gray-400 text-2xl"></i>
                                                            </div>
                                                            <p class="text-sm text-red-500 mt-1">Ảnh không tồn tại</p>
                                                        </div>
                                                    @endif
                                                    <input type="file" name="image" accept="image/*" 
                                                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                                    <p class="text-xs text-gray-500 mt-1">Chọn ảnh mới (để trống nếu giữ ảnh cũ). PNG, JPG, GIF tối đa 2MB</p>
                                                </div>
                                                
                                                <div class="grid grid-cols-2 gap-4">
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 mb-1">Đế pizza</label>
                                                        <input type="text" name="base" value="{{ $pizza->base }}"
                                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 mb-1">Loại pizza</label>
                                                        <input type="text" name="type" value="{{ $pizza->type }}"
                                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                                    </div>
                                                </div>
                                                
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">Topping</label>
                                                    <input type="text" name="topping" value="{{ $pizza->topping }}"
                                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                                </div>
                                                
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">Sốt</label>
                                                    <input type="text" name="sauce" value="{{ $pizza->sauce }}"
                                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                                </div>
                                                
                                                <div class="flex items-center">
                                                    <input type="checkbox" name="available" value="1" {{ $pizza->available ? 'checked' : '' }} id="available_{{ $pizza->id }}" 
                                                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                                    <label for="available_{{ $pizza->id }}" class="ml-2 block text-sm text-gray-900">Hiển thị cho khách hàng</label>
                                                </div>
                                                </div>
                                            </div>
                                            
                                            <div class="flex justify-end gap-3 px-6 py-4 border-t border-gray-200 bg-gray-50">
                                                <button type="button" onclick="document.getElementById('editPizza{{ $pizza->id }}').classList.add('hidden')" 
                                                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                    Hủy
                                                </button>
                                                <button type="submit" 
                                                    class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                    <i class="fas fa-save mr-1"></i> Cập nhật
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-pizza-slice text-4xl text-gray-300 mb-3"></i>
                                    <p class="text-lg font-medium text-gray-500">Chưa có pizza nào</p>
                                    <p class="text-sm text-gray-400">Hãy thêm pizza đầu tiên cho cửa hàng của bạn</p>
                                    <button onclick="document.getElementById('addPizzaModal').classList.remove('hidden')"
                                        class="mt-3 inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">
                                        <i class="fas fa-plus mr-2"></i> Thêm Pizza Đầu Tiên
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
        @endif
    </main>

    {{-- Modal xem chi tiết đơn hàng --}}
    <div id="orderDetailModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-4xl max-h-[90vh] overflow-y-auto">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-receipt text-indigo-600"></i>
                    Chi tiết đơn hàng <span id="modalOrderId"></span>
                </h3>
                <button onclick="closeOrderModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <div class="p-6">
                <div id="orderDetailContent" class="space-y-6">
                    <!-- Content will be loaded here -->
                    <div class="text-center py-8">
                        <i class="fas fa-spinner fa-spin text-4xl text-indigo-600"></i>
                        <p class="mt-4 text-gray-600">Đang tải thông tin đơn hàng...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Delete pizza function
        function deletePizza(pizzaId, pizzaName) {
            if (confirm(`⚠️ Bạn có chắc muốn xóa pizza "${pizzaName}" không?\n\nHành động này không thể hoàn tác!`)) {
                document.getElementById('delete-form-' + pizzaId).submit();
            }
        }
        
        // View order detail function
        function viewOrderDetail(orderId) {
            // Show modal
            document.getElementById('orderDetailModal').classList.remove('hidden');
            document.getElementById('modalOrderId').textContent = '#' + orderId;
            
            // Fetch order details
            fetch(`/admin/orders/${orderId}/detail`)
                .then(response => response.json())
                .then(data => {
                    console.log('Order data:', data); // Debug log
                    displayOrderDetail(data);
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('orderDetailContent').innerHTML = `
                        <div class="text-center py-8 text-red-600">
                            <i class="fas fa-exclamation-circle text-4xl"></i>
                            <p class="mt-4">Không thể tải thông tin đơn hàng</p>
                        </div>
                    `;
                });
        }
        
        function closeOrderModal() {
            document.getElementById('orderDetailModal').classList.add('hidden');
        }
        
        function displayOrderDetail(order) {
            const statusConfig = {
                'pending': { text: 'Chờ xử lý', class: 'bg-yellow-100 text-yellow-800' },
                'processing': { text: 'Đang xử lý', class: 'bg-blue-100 text-blue-800' },
                'completed': { text: 'Hoàn thành', class: 'bg-emerald-100 text-emerald-800' },
                'cancelled': { text: 'Đã hủy', class: 'bg-red-100 text-red-800' }
            };
            const config = statusConfig[order.status] || { text: order.status, class: 'bg-gray-100 text-gray-800' };
            
            const sizeLabels = {
                'small': 'Nhỏ',
                'medium': 'Vừa',
                'large': 'Lớn'
            };
            
            let itemsHtml = '';
            order.items.forEach(item => {
                console.log('Item data:', item); // Debug log
                
                // Handle different possible field names
                const size = item.pizza_size || item.size || 'medium';
                const unitPrice = parseFloat(item.unit_price || item.price || 0);
                const quantity = parseInt(item.quantity || 0);
                const totalPrice = parseFloat(item.total_price || (unitPrice * quantity) || 0);
                const pizzaName = item.pizza_name || (item.pizza ? item.pizza.name : 'Không xác định');
                
                itemsHtml += `
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-3">
                                ${item.pizza && item.pizza.image ? `
                                    <img src="/${item.pizza.image}" alt="${pizzaName}" class="w-16 h-16 object-cover rounded">
                                ` : ''}
                                <div class="font-medium text-gray-900">${pizzaName}</div>
                            </div>
                        </td>
                        <td class="px-4 py-4 text-center">
                            <span class="inline-block px-3 py-1 text-sm font-medium bg-gray-100 rounded">
                                ${sizeLabels[size] || size}
                            </span>
                        </td>
                        <td class="px-4 py-4 text-center font-medium">${quantity}</td>
                        <td class="px-4 py-4 text-right">${new Intl.NumberFormat('vi-VN').format(unitPrice)}đ</td>
                        <td class="px-4 py-4 text-right font-semibold">${new Intl.NumberFormat('vi-VN').format(totalPrice)}đ</td>
                    </tr>
                `;
            });
            
            const html = `
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Customer Info -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="font-semibold text-gray-800 mb-3 flex items-center gap-2">
                            <i class="fas fa-user text-indigo-600"></i>
                            Thông tin khách hàng
                        </h4>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tên:</span>
                                <span class="font-medium">${order.user.name}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Email:</span>
                                <span class="font-medium">${order.user.email}</span>
                            </div>
                            ${order.user.phone ? `
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Số điện thoại:</span>
                                    <span class="font-medium">${order.user.phone}</span>
                                </div>
                            ` : ''}
                        </div>
                    </div>

                    <!-- Order Info -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="font-semibold text-gray-800 mb-3 flex items-center gap-2">
                            <i class="fas fa-info-circle text-indigo-600"></i>
                            Thông tin đơn hàng
                        </h4>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Mã đơn:</span>
                                <span class="font-medium">#${order.id}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Ngày tạo:</span>
                                <span class="font-medium">${new Date(order.created_at).toLocaleString('vi-VN')}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Trạng thái:</span>
                                <span class="px-3 py-1 text-xs font-semibold rounded-full ${config.class}">
                                    ${config.text}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Update Status Form -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h4 class="font-semibold text-gray-800 mb-3 flex items-center gap-2">
                        <i class="fas fa-sync-alt text-indigo-600"></i>
                        Cập nhật trạng thái
                    </h4>
                    <form method="POST" action="/admin/orders/${order.id}/status" class="flex gap-3">
                        <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]')?.content || ''}">
                        <input type="hidden" name="_method" value="PATCH">
                        <select name="status" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                            <option value="pending" ${order.status === 'pending' ? 'selected' : ''}>Chờ xử lý</option>
                            <option value="processing" ${order.status === 'processing' ? 'selected' : ''}>Đang xử lý</option>
                            <option value="completed" ${order.status === 'completed' ? 'selected' : ''}>Hoàn thành</option>
                            <option value="cancelled" ${order.status === 'cancelled' ? 'selected' : ''}>Đã hủy</option>
                        </select>
                        <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                            <i class="fas fa-save mr-2"></i>Cập nhật
                        </button>
                    </form>
                </div>

                <!-- Order Items -->
                <div>
                    <h4 class="font-semibold text-gray-800 mb-3 flex items-center gap-2">
                        <i class="fas fa-list text-indigo-600"></i>
                        Danh sách sản phẩm
                    </h4>
                    <div class="overflow-x-auto border border-gray-200 rounded-lg">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left font-medium text-gray-700">Sản phẩm</th>
                                    <th class="px-4 py-3 text-center font-medium text-gray-700">Kích thước</th>
                                    <th class="px-4 py-3 text-center font-medium text-gray-700">Số lượng</th>
                                    <th class="px-4 py-3 text-right font-medium text-gray-700">Đơn giá</th>
                                    <th class="px-4 py-3 text-right font-medium text-gray-700">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                ${itemsHtml}
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h4 class="font-semibold text-gray-800 mb-3 flex items-center gap-2">
                        <i class="fas fa-calculator text-indigo-600"></i>
                        Tổng kết
                    </h4>
                    <div class="space-y-2">
                        <div class="flex justify-between text-gray-700">
                            <span>Tạm tính:</span>
                            <span class="font-medium">${new Intl.NumberFormat('vi-VN').format(order.subtotal)}đ</span>
                        </div>
                        ${order.discount_amount > 0 ? `
                            <div class="flex justify-between text-green-600">
                                <span>Giảm giá (${order.coupon_code}):</span>
                                <span class="font-medium">-${new Intl.NumberFormat('vi-VN').format(order.discount_amount)}đ</span>
                            </div>
                        ` : ''}
                        <div class="border-t pt-2 flex justify-between text-lg font-bold">
                            <span>Tổng cộng:</span>
                            <span class="text-indigo-600">${new Intl.NumberFormat('vi-VN').format(order.total)}đ</span>
                        </div>
                    </div>
                </div>
            `;
            
            document.getElementById('orderDetailContent').innerHTML = html;
        }
        
        // Close modal when clicking outside
        window.onclick = function(event) {
            const orderModal = document.getElementById('orderDetailModal');
            if (event.target == orderModal) {
                closeOrderModal();
            }
            
            const addModal = document.getElementById('addPizzaModal');
            if (event.target == addModal) {
                addModal.classList.add('hidden');
            }
            
            // Close edit modals
            @foreach($pizzas as $pizza)
                const editModal{{ $pizza->id }} = document.getElementById('editPizza{{ $pizza->id }}');
                if (event.target == editModal{{ $pizza->id }}) {
                    editModal{{ $pizza->id }}.classList.add('hidden');
                }
            @endforeach
        }
        
        // File input preview
        document.addEventListener('change', function(e) {
            if (e.target.type === 'file') {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        // You can add image preview logic here if needed
                        console.log('File selected:', file.name);
                    }
                    reader.readAsDataURL(file);
                }
            }
        });
        
        // Auto-hide success messages after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.bg-green-50');
            alerts.forEach(function(alert) {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);
    </script>
</body>
</html>
