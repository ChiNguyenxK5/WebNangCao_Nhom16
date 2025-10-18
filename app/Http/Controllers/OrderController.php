<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Pizza;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function create(Pizza $pizza)
    {
        return view('orders.create', compact('pizza'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'shipping_address' => 'required|string',
            'phone' => 'required|string|max:20',
            'notes' => 'nullable|string',
            'pizza_id' => 'required|exists:pizzas,id',
            'quantity' => 'required|integer|min:1',
            'pizza_size' => 'nullable|string|in:small,medium,large',
        ]);

        $pizza = Pizza::findOrFail($request->pizza_id);
        $quantity = (int) $validated['quantity'];
        $pizzaSize = $validated['pizza_size'] ?? null;

        // Optionally adjust price by size
        $unitPrice = $pizza->price;
        if ($pizzaSize === 'medium') {
            $unitPrice = $pizza->price * 1.2;
        } elseif ($pizzaSize === 'large') {
            $unitPrice = $pizza->price * 1.5;
        }

        $subtotal = round($unitPrice * $quantity, 2);
        $order = Order::create([
            'user_id' => Auth::id(),
            'shipping_address' => $validated['shipping_address'],
            'phone' => $validated['phone'],
            'notes' => $validated['notes'],
            'subtotal' => $subtotal,
            'total' => $subtotal, 
            'status' => 'pending'
        ]);

        // Tạo order item
        OrderItem::create([
            'order_id' => $order->id,
            'pizza_id' => $pizza->id,
            'pizza_name' => $pizza->name,
            'pizza_size' => $pizzaSize,
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'total_price' => $subtotal,
        ]);
        return redirect()->route('orders.show', $order)
            ->with('success', 'Đặt hàng thành công!');
    }

    public function show(Order $order)
    {
        $order->loadMissing('items.pizza', 'user');
        return view('orders.show', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled'
        ]);

        $order->update($validated);

        return back()->with('success', 'Cập nhật trạng thái đơn hàng thành công');
    }
}
