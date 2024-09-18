<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'unit_price_sell' => $this->faker->randomFloat(2, 10, 100),
            'unit_price_buy' => $this->faker->randomFloat(2, 5, 50),
            'description' => $this->faker->sentence,
            'product_category_id' => ProductCategory::factory(), // Relación con ProductCategory
        ];
    }
}
