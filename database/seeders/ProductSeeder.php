<?php

namespace Database\Seeders;

use App\Models\Categories;
use App\Models\Products;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Make sure you have at least one category to attach
        $categories = Categories::pluck('id');

        Products::factory(30)->create()->each(function ($product) use ($categories) {
            // Attach one or more random categories (1-3 for example)
            $product->categories()->attach(
                $categories->random(rand(1, 3))->unique()
            );
        });
    }
}
