<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PizzaController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileUserController;
use App\Models\Pizza;
use App\Models\Order;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [PizzaController::class, 'index'])->name('pizzas.index');

Route::get('/dashboard', function () {
    return redirect()->route('pizzas.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', function () {
        $pizzas = \App\Models\Pizza::with('category')->latest()->get();
        $totalOrders = \App\Models\Order::count();
        $totalRevenue = \App\Models\Order::sum('total');
        $totalPizzas = \App\Models\Pizza::count();

        return view('admin.dashboard', compact('pizzas', 'totalOrders', 'totalRevenue', 'totalPizzas'));
    })->name('admin.dashboard');

    Route::get('/admin/pizzas', [PizzaController::class, 'adminIndex'])->name('admin.pizzas');
    Route::post('/admin/pizzas', [PizzaController::class, 'store'])->name('admin.pizzas.store');
    Route::put('/admin/pizzas/{pizza}', [PizzaController::class, 'update'])->name('admin.pizzas.update');
    Route::delete('/admin/pizzas/{pizza}', [PizzaController::class, 'destroy'])->name('admin.pizzas.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile/user', [ProfileUserController::class, 'show'])->name('profile.user.show');
    Route::put('/profile/user', [ProfileUserController::class, 'update'])->name('profile.user.update');
});
// Routes đặt hàng
Route::get('/pizzas/{pizza}/order', [OrderController::class, 'create'])->name('orders.create');
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
// Hiển thị chi tiết đơn hàng
Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

require __DIR__ . '/auth.php';

Route::middleware(['auth'])->group(function () {
    Route::get('/orders', [App\Http\Controllers\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [App\Http\Controllers\OrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}', [App\Http\Controllers\OrderController::class, 'update'])->name('orders.update');

    Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/{cart}', [App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cart}', [App\Http\Controllers\CartController::class, 'destroy'])->name('cart.destroy');
    Route::post('/cart/checkout', [App\Http\Controllers\CartController::class, 'checkout'])->name('cart.checkout');
});
