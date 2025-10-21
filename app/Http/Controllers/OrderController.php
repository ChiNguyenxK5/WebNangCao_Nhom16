<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Pizza;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Coupon;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
                      ->where('status', '!=', 'cancelled')
                      ->with('items.pizza')
                      ->orderBy('created_at', 'desc')
                      ->get();
        
        return view('user.orders.index', compact('orders'));
    }

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
            ->with('success', 'Đặt giỏ hàng thành công!');
    }

    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
        
        $order->loadMissing('items.pizza', 'user');
        $pizzas = Pizza::all();
        return view('user.orders.show', compact('order', 'pizzas'));
    }

    // Update a specific order item (quantity/size)
    public function updateItem(Request $request, Order $order, \App\Models\OrderItem $item)
    {
        // ensure the item belongs to the order
        if ($item->order_id !== $order->id) {
            abort(404);
        }

        // only owner or admin can update and only when pending
        if ($order->user_id !== Auth::id() && !Auth::user()->isAdmin ?? false) {
            abort(403);
        }

        if (! in_array($order->status, ['pending', 'processing'])) {
            return back()->with('error', 'Không thể chỉnh sửa giỏ hàng đã xử lý');
        }

        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
            'pizza_size' => 'nullable|string|in:small,medium,large',
        ]);

        $quantity = (int) $validated['quantity'];
        $size = $validated['pizza_size'] ?? $item->pizza_size;

        // determine unit price adjustment based on size
        $unitPrice = $item->unit_price;
        // If pizza model available, compute base price; otherwise adjust from existing unit_price
        if ($item->pizza) {
            $base = $item->pizza->price;
            if ($size === 'medium') $unitPrice = $base * 1.2;
            elseif ($size === 'large') $unitPrice = $base * 1.5;
            else $unitPrice = $base;
        } else {
            if ($size === 'medium') $unitPrice = $item->unit_price * 1.2;
            elseif ($size === 'large') $unitPrice = $item->unit_price * 1.5;
        }

        $item->update([
            'quantity' => $quantity,
            'pizza_size' => $size,
            'unit_price' => round($unitPrice, 2),
            'total_price' => round($unitPrice * $quantity, 2),
        ]);

        // Recalculate order totals
        $subtotal = $order->items()->sum('total_price');
        $order->subtotal = $subtotal;
        $order->total = $subtotal - ($order->discount_amount ?? 0);
        $order->save();

        // Return JSON for AJAX requests
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Cập nhật thành công',
                'item' => [
                    'id' => $item->id,
                    'quantity' => $item->quantity,
                    'size' => $item->pizza_size,
                    'unit_price' => $item->unit_price,
                    'total_price' => $item->total_price,
                ],
                'order' => [
                    'subtotal' => $order->subtotal,
                    'total' => $order->total,
                ]
            ]);
        }

        return back()->with('success', 'Cập nhật mục trong giỏ hàng thành công');
    }

    public function deleteItem(Request $request, $orderId, $itemId)
    {
        $order = Order::findOrFail($orderId);
        $item = OrderItem::where('order_id', $order->id)->findOrFail($itemId);
        if ($order->user_id !== Auth::id() && !(Auth::user()->isAdmin ?? false)) {
            abort(403, 'Unauthorized');
        }
        if (! in_array($order->status, ['pending', 'processing'])) {
            return redirect()->back()->with('error', 'Không thể xóa món khi đơn đã đặt hàng hoặc huỷ.');
        }
        $item->delete();
        $order->recalculateTotal();
        return redirect()->route('orders.show', $order->id)->with('success', 'Xóa món thành công.');
    }
    // Add a new item to an existing order (only when pending)
    public function addItem(Request $request, Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if (! in_array($order->status, ['pending', 'processing'])) {
            return back()->with('error', 'Không thể thêm mục vào giỏ hàng đã xử lý');
        }

        $validated = $request->validate([
            'pizza_id' => 'required|exists:pizzas,id',
            'quantity' => 'required|integer|min:1',
            'pizza_size' => 'nullable|string|in:small,medium,large',
        ]);

        $pizza = Pizza::findOrFail($validated['pizza_id']);
        $quantity = (int) $validated['quantity'];
        $size = $validated['pizza_size'] ?? null;

        $unitPrice = $pizza->price;
        if ($size === 'medium') $unitPrice = $pizza->price * 1.2;
        elseif ($size === 'large') $unitPrice = $pizza->price * 1.5;

        $totalPrice = round($unitPrice * $quantity, 2);

        \App\Models\OrderItem::create([
            'order_id' => $order->id,
            'pizza_id' => $pizza->id,
            'pizza_name' => $pizza->name,
            'pizza_size' => $size,
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'total_price' => $totalPrice,
        ]);

        // Recalc order totals
        $subtotal = $order->items()->sum('total_price');
        $order->subtotal = $subtotal;
        $order->total = $subtotal - ($order->discount_amount ?? 0);
        $order->save();

    return back()->with('success', 'Đã thêm món mới vào giỏ hàng');
    }

    public function update(Request $request, Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'action' => 'required|string|in:cancel,place'
        ]);

        if ($request->action === 'cancel' && in_array($order->status, ['pending', 'processing'])) {
            $order->update(['status' => 'cancelled']);
            return redirect()->route('orders.index')->with('success', 'Giỏ hàng đã được hủy thành công!');
        }

        if ($request->action === 'place' && $order->status === 'pending') {
            // user confirms placing the order -> mark as processing
            $order->update(['status' => 'processing']);
            return redirect()->route('orders.index')->with('success', 'Đặt hàng thành công!');
        }

        return redirect()->back()->with('error', 'Không thể thực hiện hành động này!');
    }
    public function reopenOrder(Request $request, Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        if ($order->status !== 'processing') {
            return redirect()->back()->with('error', 'Chỉ có thể sửa đơn đang xử lý.');
        }

        // Already in processing, just redirect to show page
        return redirect()->route('orders.show', $order->id);
    }

    // Apply a coupon to an existing pending order
    public function applyCoupon(Request $request, Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if (! in_array($order->status, ['pending', 'processing'])) {
            return back()->with('error', 'Chỉ có thể áp dụng mã cho đơn đang xử lý');
        }

        $data = $request->validate([
            'coupon_code' => 'required|string'
        ]);

        $code = trim($data['coupon_code']);
        $coupon = Coupon::where('code', $code)->first();

        if (! $coupon || ! $coupon->isValid()) {
            return back()->with('error', 'Mã giảm giá không hợp lệ hoặc đã hết hạn');
        }

        // check minimum amount
        if ($coupon->minimum_amount && $order->subtotal < $coupon->minimum_amount) {
            return back()->with('error', 'Giỏ hàng chưa đạt mức tối thiểu để áp dụng mã này');
        }

        // compute discount
        $discount = 0;
        if ($coupon->type === 'percent') {
            $discount = round($order->subtotal * ($coupon->value / 100), 2);
        } else { // fixed
            $discount = round(min($coupon->value, $order->subtotal), 2);
        }

        DB::transaction(function () use ($order, $coupon, $discount) {
            // attach coupon to order
            $order->coupon_id = $coupon->id;
            $order->coupon_code = $coupon->code;
            $order->discount_amount = $discount;
            $order->total = max(0, $order->subtotal - $discount);
            $order->save();

            // increment used_count
            $coupon->used_count = ($coupon->used_count ?? 0) + 1;
            $coupon->save();
        });

        return back()->with('success', 'Áp dụng mã giảm giá thành công');
    }

    // Remove coupon from order
    public function removeCoupon(Request $request, Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if (! in_array($order->status, ['pending', 'processing'])) {
            return back()->with('error', 'Chỉ có thể xóa mã cho đơn đang xử lý');
        }

        if (! $order->coupon_id) {
            return back()->with('error', 'Đơn không có mã để xóa');
        }

        DB::transaction(function () use ($order) {
            $coupon = $order->coupon;
            $order->coupon_id = null;
            $order->coupon_code = null;
            $order->discount_amount = 0;
            $order->total = $order->subtotal;
            $order->save();

            if ($coupon) {
                $coupon->used_count = max(0, ($coupon->used_count ?? 1) - 1);
                $coupon->save();
            }
        });

        return back()->with('success', 'Đã xóa mã giảm giá');
    }

    // Admin Methods
    public function adminIndex(Request $request)
    {
        // Get pizzas for the pizzas tab
        $pizzas = \App\Models\Pizza::with('category')->latest()->get();
        
        $query = Order::with(['user', 'items.pizza'])
                     ->orderBy('created_at', 'desc');

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Search by user name or order ID
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $orders = $query->paginate(20);

        $statusCounts = [
            'all' => Order::count(),
            'pending' => Order::where('status', 'pending')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'completed' => Order::where('status', 'completed')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
        ];

        return view('admin.pizzas.index', compact('orders', 'statusCounts', 'pizzas'));
    }

    public function getOrderDetail(Order $order)
    {
        $order->load(['user', 'items.pizza']);
        return response()->json($order);
    }

    public function adminShow(Order $order)
    {
        $order->load(['user', 'items.pizza']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);

        $order->status = $request->status;
        $order->save();

        return back()->with('success', 'Đã cập nhật trạng thái đơn hàng');
    }

    public function completeOrder(Order $order)
    {
        if ($order->status === 'cancelled') {
            return back()->with('error', 'Không thể hoàn thành đơn hàng đã bị hủy');
        }

        if ($order->status === 'completed') {
            return back()->with('info', 'Đơn hàng đã được hoàn thành trước đó');
        }

        $order->status = 'completed';
        $order->save();

        return back()->with('success', 'Đã hoàn thành đơn hàng #' . $order->id);
    }
}