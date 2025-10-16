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
            'base' => 'nullable|string',
            'topping' => 'nullable|string',
            'sauce' => 'nullable|string',
            'type' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'available' => 'boolean',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads'), $imageName);
            $data['image_url'] = 'uploads/' . $imageName;
        } else {
            $data['image_url'] = 'uploads/default-pizza.jpg'; // Default image
        }

        // Remove 'image' from data array as it's not a database field
        unset($data['image']);

        // ensure available defaults to true if not provided
        if (! array_key_exists('available', $data)) {
            $data['available'] = true;
        }

        Pizza::create($data);
        return redirect()->back()->with('success', 'Đã thêm pizza mới!');
    }

    // Cập nhật
    public function update(Request $request, Pizza $pizza)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'size' => 'nullable|string',
            'base' => 'nullable|string',
            'topping' => 'nullable|string',
            'sauce' => 'nullable|string',
            'type' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'available' => 'boolean',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($pizza->image_url && file_exists(public_path($pizza->image_url))) {
                unlink(public_path($pizza->image_url));
            }

            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads'), $imageName);
            $data['image_url'] = 'uploads/' . $imageName;
        }

        // Remove 'image' from data array as it's not a database field
        unset($data['image']);

        // ensure available defaults to current value if not provided
        if (! array_key_exists('available', $data)) {
            $data['available'] = false;
        }

        $pizza->update($data);
        return redirect()->back()->with('success', 'Cập nhật pizza thành công!');
    }

    // Xóa
    public function destroy(Pizza $pizza)
    {
        // Delete image file if exists
        if ($pizza->image_url && $pizza->image_url !== 'uploads/default-pizza.jpg') {
            $imagePath = public_path($pizza->image_url);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $pizza->delete();
        return redirect()->back()->with('success', 'Đã xóa pizza "' . $pizza->name . '" thành công!');
    }
}
