{{-- Nút thêm pizza --}}
<div class="mb-6">
    <a href="#addPizzaModal"
       class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 flex items-center gap-2 w-fit"
       onclick="document.getElementById('addPizzaModal').classList.remove('hidden')">
        <i class="fas fa-plus"></i> Thêm pizza mới
    </a>
</div>

{{-- Modal thêm pizza --}}
<div id="addPizzaModal" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center">
    <form action="{{ route('admin.pizzas.store') }}" method="POST" class="bg-white p-6 rounded-lg w-96">
        @csrf
        <h2 class="text-lg font-semibold mb-4">Thêm pizza mới</h2>
        <input type="text" name="name" placeholder="Tên pizza" class="w-full mb-2 border p-2 rounded" required>
        <input type="text" name="description" placeholder="Mô tả" class="w-full mb-2 border p-2 rounded">
        <input type="number" name="price" placeholder="Giá" class="w-full mb-2 border p-2 rounded" step="0.01" required>
        <input type="text" name="image_url" placeholder="URL ảnh" class="w-full mb-2 border p-2 rounded">
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

{{-- Bảng pizza admin --}}
<table class="w-full text-left text-gray-600 text-sm">
    <thead class="border-b border-gray-200 bg-gray-50">
        <tr>
            <th class="px-6 py-3 font-semibold uppercase tracking-wide">Mã</th>
            <th class="px-6 py-3 font-semibold uppercase tracking-wide">Tên</th>
            <th class="px-6 py-3 font-semibold uppercase tracking-wide">Mô tả</th>
            <th class="px-6 py-3 font-semibold uppercase tracking-wide">Giá</th>
            <th class="px-6 py-3 font-semibold uppercase tracking-wide">Loại</th>
            <th class="px-6 py-3 font-semibold uppercase tracking-wide">Hiển thị</th>
            <th class="px-6 py-3 font-semibold uppercase tracking-wide text-right">Thao tác</th>
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
            <td class="px-6 py-4">{{ $pizza->type }}</td>
            <td class="px-6 py-4">
                {{ $pizza->available ? 'Có' : 'Không' }}
            </td>
            <td class="px-6 py-4 text-right flex gap-2 justify-end">
                {{-- Sửa --}}
                <a href="#editPizza{{ $pizza->id }}" class="text-indigo-600 hover:text-indigo-900"
                   onclick="document.getElementById('editPizza{{ $pizza->id }}').classList.remove('hidden')">
                    <i class="fas fa-edit"></i>
                </a>
                {{-- Xóa --}}
                <form action="{{ route('admin.pizzas.destroy', $pizza->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-900"
                            onclick="return confirm('Bạn chắc muốn xóa pizza này?')">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>

                {{-- Modal sửa --}}
                <div id="editPizza{{ $pizza->id }}" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center">
                    <form action="{{ route('admin.pizzas.update', $pizza->id) }}" method="POST" class="bg-white p-6 rounded-lg w-96">
                        @csrf
                        @method('PUT')
                        <h2 class="text-lg font-semibold mb-4">Sửa pizza</h2>
                        <input type="text" name="name" value="{{ $pizza->name }}" class="w-full mb-2 border p-2 rounded">
                        <input type="text" name="description" value="{{ $pizza->description }}" class="w-full mb-2 border p-2 rounded">
                        <input type="number" name="price" value="{{ $pizza->price }}" class="w-full mb-2 border p-2 rounded" step="0.01">
                        <input type="text" name="image_url" value="{{ $pizza->image_url }}" class="w-full mb-2 border p-2 rounded">
                        <input type="text" name="base" value="{{ $pizza->base }}" class="w-full mb-2 border p-2 rounded">
                        <input type="text" name="topping" value="{{ $pizza->topping }}" class="w-full mb-2 border p-2 rounded">
                        <input type="text" name="sauce" value="{{ $pizza->sauce }}" class="w-full mb-2 border p-2 rounded">
                        <input type="text" name="type" value="{{ $pizza->type }}" class="w-full mb-2 border p-2 rounded">
                        <input type="text" name="size" value="{{ $pizza->size }}" class="w-full mb-2 border p-2 rounded">
                        <label class="flex items-center gap-2 mb-2">
                            <input type="checkbox" name="available" value="1" {{ $pizza->available ? 'checked' : '' }}> Hiển thị cho user
                        </label>
                        <div class="flex justify-end gap-2">
                            <button type="button" onclick="document.getElementById('editPizza{{ $pizza->id }}').classList.add('hidden')" class="px-3 py-1 border rounded">Hủy</button>
                            <button type="submit" class="px-3 py-1 bg-indigo-600 text-white rounded">Cập nhật</button>
                        </div>
                    </form>
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                Chưa có pizza nào.
            </td>
        </tr>
        @endforelse
    </tbody>
</table>
