<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Pizza;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('pizza')->get();
        $total = $cartItems->sum(function ($item) {
            return $item->pizza->price * $item->quantity;
        });

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'pizza_id' => 'required|exists:pizzas,id',
            'quantity' => 'required|integer|min:1',
            'size' => 'required|in:S,M,L'
        ]);

        $existingItem = Cart::where([
            'user_id' => Auth::id(),
            'pizza_id' => $request->pizza_id,
            'size' => $request->size
        ])->first();

        if ($existingItem) {
            $existingItem->quantity += $request->quantity;
            $existingItem->save();
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'pizza_id' => $request->pizza_id,
                'quantity' => $request->quantity,
                'size' => $request->size
            ]);
        }

        return redirect()->back()->with('success', 'Đã thêm vào giỏ hàng!');
    }

    public function update(Request $request, Cart $cart)
    {
        if ($cart->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cart->update(['quantity' => $request->quantity]);

        return redirect()->back()->with('success', 'Đã cập nhật giỏ hàng!');
    }

    public function destroy(Cart $cart)
    {
        if ($cart->user_id !== Auth::id()) {
            abort(403);
        }

        $cart->delete();

        return redirect()->back()->with('success', 'Đã xóa khỏi giỏ hàng!');
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'required|string|max:500',
            'notes' => 'nullable|string|max:1000'
        ]);

        $cartItems = Cart::where('user_id', Auth::id())->with('pizza')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Giỏ hàng trống!');
        }

        DB::transaction(function () use ($cartItems, $request) {
            $total = $cartItems->sum(function ($item) {
                return $item->pizza->price * $item->quantity;
            });

            $order = Order::create([
                'user_id' => Auth::id(),
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'customer_address' => $request->customer_address,
                'notes' => $request->notes,
                'total' => $total,
                'status' => 'pending'
            ]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'pizza_id' => $item->pizza_id,
                    'pizza_name' => $item->pizza->name,
                    'quantity' => $item->quantity,
                    'size' => $item->size,
                    'price' => $item->pizza->price
                ]);
            }

            Cart::where('user_id', Auth::id())->delete();
        });

        return redirect()->route('orders.index')->with('success', 'Đặt hàng thành công!');
    }
}
