<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{User, Pizza, Order, OrderItem};

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $pizzas = Pizza::all();

        if ($users->isEmpty() || $pizzas->isEmpty()) {
            return;
        }

        foreach (range(1, 10) as $i) {
            $user = $users->random();
            // Tính toán subtotal trước
            $subtotal = 0;
            $items = rand(1, 3);
            for ($j = 0; $j < $items; $j++) {
                $pizza = $pizzas->random();
                $qty = rand(1, 3);
                $price = $pizza->price;
                $subtotal += $price * $qty;
            }

            $order = Order::create([
                'user_id' => $user->id,
                'subtotal' => $subtotal,
                'discount_amount' => 0,
                'total' => $subtotal,
                'status' => fake()->randomElement(['pending', 'confirmed', 'completed']),
                'shipping_address' => $user->address ?? fake()->address(),
                'phone' => $user->phone ?? fake()->phoneNumber(),
                'notes' => fake()->optional()->sentence(),
            ]);

            // Tạo order items
            for ($j = 0; $j < $items; $j++) {
                $pizza = $pizzas->random();
                $qty = rand(1, 3);
                $price = $pizza->price;
                OrderItem::create([
                    'order_id' => $order->id,
                    'pizza_id' => $pizza->id,
                    'pizza_name' => $pizza->name,
                    'pizza_size' => $pizza->size,
                    'quantity' => $qty,
                    'unit_price' => $price,
                    'total_price' => $price * $qty,
                ]);
            }
        }
    }
}
