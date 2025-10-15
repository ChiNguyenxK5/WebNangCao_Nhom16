<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sản phẩm Pizza</title>
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
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 text-gray-900 font-semibold">
                    <i class="fas fa-th-large"></i> Tổng quan
                </a>
                <a href="{{ route('admin.pizzas') }}" class="flex items-center gap-3 text-indigo-600 font-semibold">
                    <i class="fas fa-box"></i> Sản phẩm
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
            <span class="text-indigo-600">Sản phẩm</span>
        </div>

        <h1 class="text-3xl font-extrabold text-gray-900 flex items-center gap-2 mb-1">
            <i class="fas fa-box text-indigo-600"></i> Quản lý sản phẩm Pizza
        </h1>
        <p class="text-gray-700 mb-6">Quản lý danh sách sản phẩm pizza của cửa hàng</p>

        {{-- Nút thêm --}}
        <div class="mb-6">
            <a href="{{ route('admin.pizzas') }}"
                class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 flex items-center gap-2 w-fit">
                <i class="fas fa-plus"></i> Thêm sản phẩm mới
            </a>
        </div>

        {{-- Bảng sản phẩm --}}
        <section class="bg-white border border-gray-200 rounded-lg shadow-sm">
            <header class="flex justify-between items-center px-6 py-4 border-b border-gray-200">
                <h2 class="font-semibold text-gray-900">Danh sách sản phẩm</h2>
            </header>

            <table class="w-full text-left text-gray-600 text-sm">
                <thead class="border-b border-gray-200 bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 font-semibold uppercase tracking-wide">Mã SP</th>
                        <th class="px-6 py-3 font-semibold uppercase tracking-wide">Tên sản phẩm</th>
                        <th class="px-6 py-3 font-semibold uppercase tracking-wide">Mô tả</th>
                        <th class="px-6 py-3 font-semibold uppercase tracking-wide">Giá</th>
                        <th class="px-6 py-3 font-semibold uppercase tracking-wide">Loại</th>
                        <th class="px-6 py-3 text-right font-semibold uppercase tracking-wide">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pizzas as $pizza)
                        <tr class="hover:bg-gray-50 border-b">
                            <td class="px-6 py-4 font-medium">#{{ $pizza->id }}</td>
                            <td class="px-6 py-4 flex items-center gap-3">
                                <img src="{{ asset($pizza->image_url) }}" class="w-10 h-10 object-cover rounded">
                                {{ $pizza->name }}
                            </td>
                            <td class="px-6 py-4">{{ Str::limit($pizza->description, 50) }}</td>
                            <td class="px-6 py-4">{{ number_format($pizza->price) }}đ</td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-2 py-1 rounded-full text-xs font-medium {{ $pizza->type === 'hot' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}">
                                    {{ $pizza->type === 'hot' ? 'Bán chạy' : 'Khuyến mãi' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="#" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                    <i class="fas fa-edit"></i> Sửa
                                </a>
                                <form action="{{ route('admin.pizzas.destroy', $pizza->id) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-red-600 hover:text-red-900"
                                        onclick="return confirm('Bạn chắc muốn xóa sản phẩm này?')">
                                        <i class="fas fa-trash"></i> Xóa
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                Hiện chưa có sản phẩm nào.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>
