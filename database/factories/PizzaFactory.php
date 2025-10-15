<?php

namespace Database\Factories;

use App\Models\Pizza;
use Illuminate\Database\Eloquent\Factories\Factory;

class PizzaFactory extends Factory
{
    protected $model = Pizza::class;

    public function definition()
    {
        $sizes = ['Small', 'Medium', 'Large'];
        return [
            'name' => $this->faker->words(2, true) . ' Pizza',
            'description' => $this->faker->sentence(),
            'price' => $this->faker->randomFloat(2, 50, 300),
            'size' => $this->faker->randomElement($sizes),
            'topping' => $this->faker->randomElement(['Cheese', 'Pepperoni', 'Veggie', 'Seafood']),
            'image_url' => null,
            'available' => $this->faker->boolean(90),
            'base' => $this->faker->randomElement(['Thin', 'Thick', 'Cheesy']),
            'sauce' => $this->faker->randomElement(['Tomato', 'Cream', 'Pesto']),
            'type' => $this->faker->randomElement(['Classic', 'Gourmet', 'Special']),
        ];
    }
}
