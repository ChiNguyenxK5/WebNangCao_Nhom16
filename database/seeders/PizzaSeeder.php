<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pizza;

class PizzaSeeder extends Seeder
{
    public function run(): void
    {
        // Tạo một số pizza cụ thể với category
        $pizzas = [
            [
                'category_id' => 1, // Pizza Truyền Thống
                'name' => 'Margherita',
                'description' => 'Pizza cơ bản với cà chua, phô mai mozzarella và lá húng quế',
                'ingredients' => 'Cà chua, phô mai mozzarella, lá húng quế, dầu olive',
                'price' => 120.00,
                'size' => 'Medium',
                'topping' => 'Cheese',
                'available' => true,
                'base' => 'Thin',
                'sauce' => 'Tomato',
                'type' => 'Classic',
            ],
            [
                'category_id' => 2, // Pizza Hải Sản
                'name' => 'Seafood Deluxe',
                'description' => 'Pizza hải sản cao cấp với tôm, mực, cua',
                'ingredients' => 'Tôm, mực, thịt cua, phô mai, hành tây',
                'price' => 250.00,
                'size' => 'Large',
                'topping' => 'Seafood',
                'available' => true,
                'base' => 'Thick',
                'sauce' => 'Cream',
                'type' => 'Premium',
            ],
            [
                'category_id' => 3, // Pizza Thịt
                'name' => 'Pepperoni',
                'description' => 'Pizza với xúc xích pepperoni thơm ngon',
                'ingredients' => 'Xúc xích pepperoni, phô mai mozzarella, sốt cà chua',
                'price' => 180.00,
                'size' => 'Medium',
                'topping' => 'Pepperoni',
                'available' => true,
                'base' => 'Thin',
                'sauce' => 'Tomato',
                'type' => 'Popular',
            ]
        ];

        foreach ($pizzas as $pizza) {
            Pizza::create($pizza);
        }

        // Tạo thêm pizza ngẫu nhiên
        Pizza::factory()->count(7)->create();
    }
}
