<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Pizza - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet" />
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
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 text-gray-700 hover:text-gray-900 font-medium">
                    <i class="fas fa-th-large"></i> Tổng quan
                </a>
                <a href="{{ route('admin.pizzas') }}" class="flex items-center gap-3 text-indigo-600 font-semibold">
                    <i class="fas fa-pizza-slice"></i> Quản lý Pizza
                </a>
            </nav>
        </div>

        <div class="px-6 py-5 border-t border-gray-200">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600">
                    <i class="fas fa-user-shield"></i>
                </div>
                <div>
                    <p class="text-gray-900 font-semibold text-sm">{{ auth()->user()->name }}</p>
                    <p class="text-gray-500 text-xs">Quản trị viên</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full flex items-center justify-center gap-2 border border-gray-300 rounded-md py-2 text-gray-700 font-medium text-sm hover:bg-gray-50 transition-colors">
                    <i class="fas fa-sign-out-alt"></i> Đăng xuất
                </button>
            </form>
        </div>
    </aside>

    {{-- Nội dung chính --}}
    <main class="flex-1 p-6">
        <div class="mb-4 text-sm text-gray-600">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-indigo-600">Tổng quan</a> /
            <span class="text-indigo-600">Quản lý Pizza</span>
        </div>

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

        {{-- Modal thêm pizza --}}
        <div id="addPizzaModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-md">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                        <i class="fas fa-plus-circle text-indigo-600"></i>
                        Thêm Pizza Mới
                    </h3>
                </div>
                
                <form action="{{ route('admin.pizzas.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
                    @csrf
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
                    
                    <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-200">
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
        <input type="text" name="base" placeholder="Đế" class="w-full mb-2 border p-2 rounded">
        <input type="text" name="topping" placeholder="Topping" class="w-full mb-2 border p-2 rounded">
        <input type="text" name="sauce" placeholder="Sốt" class="w-full mb-2 border p-2 rounded">
        <input type="text" name="type" placeholder="Loại pizza" class="w-full mb-2 border p-2 rounded">
        <input type="text" name="size" placeholder="Size" class="w-full mb-2 border p-2 rounded">
        <label class="flex items-center gap-2 mb-2">
            <input type="checkbox" name="available" value="1"> Hiển thị cho user
        </label>
        <div class="flex justify-end gap-2">
            <button type="button" onclick="document.getElementById('addPizzaModal').classList.add('hidden')" class="px-3 py-1 border rounded">Hủy</button>
            <button type="submit" class="px-3 py-1 bg-indigo-600 text-white rounded">Thêm</button>
        </div>
    </form>
</div>

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
                                    <div class="bg-white rounded-lg shadow-xl w-full max-w-md max-h-[90vh] overflow-y-auto">
                                        <div class="px-6 py-4 border-b border-gray-200">
                                            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                                                <i class="fas fa-edit text-indigo-600"></i>
                                                Chỉnh sửa Pizza: {{ $pizza->name }}
                                            </h3>
                                        </div>
                                        
                                        <form action="{{ route('admin.pizzas.update', $pizza->id) }}" method="POST" enctype="multipart/form-data" class="p-6">
                                            @csrf
                                            @method('PUT')
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
                                            
                                            <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-200">
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
    </main>
    
    <script>
        // Delete pizza function
        function deletePizza(pizzaId, pizzaName) {
            if (confirm(`⚠️ Bạn có chắc muốn xóa pizza "${pizzaName}" không?\n\nHành động này không thể hoàn tác!`)) {
                document.getElementById('delete-form-' + pizzaId).submit();
            }
        }
        
        // Close modal when clicking outside
        window.onclick = function(event) {
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
