<?php

namespace App\Http\Controllers;

use App\Models\Pizza;
use Illuminate\Http\Request;

class PizzaController extends Controller
{
    public function index(Request $request)
    {
        $selectedTopping = $request->get('topping', 'all');

        $query = Pizza::where('available', true);

        if ($selectedTopping !== 'all') {
            $query->where('topping', $selectedTopping);
        }

        $pizzas = $query->get();

        $toppings = Pizza::select('topping')
            ->whereNotNull('topping')
            ->distinct()
            ->pluck('topping')
            ->filter()
            ->sort();

        return view('user.home', compact('pizzas', 'toppings', 'selectedTopping'));
    }

    public function adminIndex()
    {
        $pizzas = Pizza::all();
        return view('admin.pizzas.index', compact('pizzas'));
    }

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

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads'), $imageName);
            $data['image_url'] = 'uploads/' . $imageName;
        } else {
            $data['image_url'] = 'uploads/default-pizza.jpg';
        }

        unset($data['image']);

        if (! array_key_exists('available', $data)) {
            $data['available'] = true;
        }

        Pizza::create($data);
        return redirect()->back()->with('success', 'Đã thêm pizza mới!');
    }

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

        if ($request->hasFile('image')) {
            if ($pizza->image_url && file_exists(public_path($pizza->image_url))) {
                unlink(public_path($pizza->image_url));
            }

            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads'), $imageName);
            $data['image_url'] = 'uploads/' . $imageName;
        }

        unset($data['image']);

        if (! array_key_exists('available', $data)) {
            $data['available'] = false;
        }

        $pizza->update($data);
        return redirect()->back()->with('success', 'Cập nhật pizza thành công!');
    }

    public function destroy(Pizza $pizza)
    {
        $pizzaName = $pizza->name;

        if ($pizza->image_url && $pizza->image_url !== 'uploads/default-pizza.jpg') {
            $imagePath = public_path($pizza->image_url);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $pizza->delete();

        if (request()->is('dashboard') || str_contains(request()->url(), 'dashboard')) {
            return redirect()->route('admin.dashboard')->with('success', 'Đã xóa pizza "' . $pizzaName . '" thành công!');
        } else {
            return redirect()->route('admin.pizzas')->with('success', 'Đã xóa pizza "' . $pizzaName . '" thành công!');
        }
    }
}
