<?php

namespace App\Http\Controllers;

use App\Models\Pizza;
use Illuminate\Http\Request;

class PizzaController extends Controller
{
    // Trang user — hiển thị danh sách pizza
    public function index()
    {
        $pizzas = Pizza::where('available', true)->get();
        return view('user.home', compact('pizzas'));
    }

    // Trang admin — quản lý pizza
    public function adminIndex()
    {
        $pizzas = Pizza::all();
        return view('admin.pizzas.index', compact('pizzas'));
    }

    // Thêm mới
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'size' => 'nullable|string',
            'topping' => 'nullable|string',
            'image_url' => 'nullable|string',
            'available' => 'boolean',
        ]);
        // ensure available defaults to true if not provided
        if (! array_key_exists('available', $data)) {
            $data['available'] = true;
        }

        // map image_url if the form used 'image' accidentally
        if (! array_key_exists('image_url', $data) && $request->filled('image')) {
            $data['image_url'] = $request->input('image');
        }

        Pizza::create($data);
        return redirect()->back()->with('success', 'Đã thêm pizza mới!');
    }

    // Cập nhật
    public function update(Request $request, Pizza $pizza)
    {
        $pizza->update($request->all());
        return redirect()->back()->with('success', 'Cập nhật pizza thành công!');
    }

    // Xóa
    public function destroy(Pizza $pizza)
    {
        $pizza->delete();
        return redirect()->back()->with('success', 'Đã xóa pizza!');
    }
}
