<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Pizza Truyền Thống',
                'slug' => 'pizza-truyen-thong',
                'description' => 'Các loại pizza với hương vị truyền thống',
                'is_active' => true
            ],
            [
                'name' => 'Pizza Hải Sản',
                'slug' => 'pizza-hai-san',
                'description' => 'Pizza với topping hải sản tươi ngon',
                'is_active' => true
            ],
            [
                'name' => 'Pizza Thịt',
                'slug' => 'pizza-thit',
                'description' => 'Pizza với các loại thịt đa dạng',
                'is_active' => true
            ],
            [
                'name' => 'Pizza Chay',
                'slug' => 'pizza-chay',
                'description' => 'Pizza dành cho người ăn chay',
                'is_active' => true
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
