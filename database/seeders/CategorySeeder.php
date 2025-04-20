<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::insert([
            // ['name' => 'Mens', 'slug' => 'mens', 'category_code' => 'M', 'created_at' => now(), 'updated_at' => now()],
            // ['name' => 'Womens', 'slug' => 'womens', 'category_code' => 'W', 'created_at' => now(), 'updated_at' => now()],
            // ['name' => 'Kids', 'slug' => 'kids', 'category_code' => 'K', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'T-shirts', 'slug' => 't-shirts', 'category_code' => 'TS', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Long Sleeve T-shirts', 'slug' => 'long-sleeve-t-shirts', 'category_code' => 'LSTS', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Oversized T-shirts', 'slug' => 'oversized-t-shirts', 'category_code' => 'OTS', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Hoodies', 'slug' => 'hoodies', 'category_code' => 'H', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Oversized Hoodies', 'slug' => 'oversized-hoodies', 'category_code' => 'OH', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sweatshirts', 'slug' => 'sweatshirts', 'category_code' => 'SS', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
