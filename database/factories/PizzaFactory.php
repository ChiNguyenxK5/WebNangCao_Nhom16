<?php

namespace Database\Factories;

use App\Models\Pizza;
use Illuminate\Database\Eloquent\Factories\Factory;

class PizzaFactory extends Factory
{
    protected $model = Pizza::class;

    public function definition()
    {
        $sizes = ['Nhỏ', 'Vừa', 'Lớn'];
        $bases = ['Đế mỏng', 'Đế dày', 'Phô mai viền'];
        $sauces = ['Sốt cà chua', 'Sốt kem', 'Sốt pesto'];
        $types = ['Truyền thống', 'Cao cấp', 'Đặc biệt'];
        $toppings = ['Phô mai', 'Xúc xích', 'Hải sản', 'Thịt bò', 'Gà nướng', 'Thập cẩm'];

        return [
            'category_id' => $this->faker->numberBetween(1, 3),
            'name' => 'Pizza ' . $this->faker->randomElement(['Bò', 'Gà', 'Hải Sản', 'Thập Cẩm', 'Phô Mai']),
            'description' => $this->faker->sentence(8, true) . ' (hương vị hấp dẫn, phù hợp với mọi lứa tuổi).',
            'ingredients' => 'Phô mai, cà chua, hành tây, ' . $this->faker->randomElement(['tôm', 'bò', 'gà', 'nấm', 'ớt chuông']),
            'price' => $this->faker->numberBetween(100000, 300000),
            'size' => $this->faker->randomElement($sizes),
            'topping' => $this->faker->randomElement($toppings),
            'image_url' => null,
            'available' => $this->faker->boolean(90),
            'base' => $this->faker->randomElement($bases),
            'sauce' => $this->faker->randomElement($sauces),
            'type' => $this->faker->randomElement($types),
        ];
    }
}