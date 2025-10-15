<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PizzaController;
use App\Http\Controllers\ProductController;
use App\Models\Pizza;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Trang chủ — danh sách pizza (user)
Route::get('/', [PizzaController::class, 'index'])->name('pizzas.index');

// Dashboard mặc định Breeze
Route::get('/dashboard', function () {
    $pizzas = Pizza::all();
    return view('dashboard', compact('pizzas'));
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile user (Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Trang admin — sử dụng middleware admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', function () {
        // Truyền data cần thiết cho admin dashboard
        $pizzas = \App\Models\Pizza::with('category')->latest()->take(10)->get();
        $totalOrders = \App\Models\Order::count();
        $totalRevenue = \App\Models\Order::sum('total');
        $totalPizzas = \App\Models\Pizza::count();

        return view('admin.dashboard', compact('pizzas', 'totalOrders', 'totalRevenue', 'totalPizzas'));
    })->name('admin.dashboard');

    // CRUD Pizza cho admin
    Route::get('/admin/pizzas', [PizzaController::class, 'adminIndex'])->name('admin.pizzas');
    Route::post('/admin/pizzas', [PizzaController::class, 'store'])->name('admin.pizzas.store');
    Route::put('/admin/pizzas/{pizza}', [PizzaController::class, 'update'])->name('admin.pizzas.update');
    Route::delete('/admin/pizzas/{pizza}', [PizzaController::class, 'destroy'])->name('admin.pizzas.destroy');
});

require __DIR__ . '/auth.php';