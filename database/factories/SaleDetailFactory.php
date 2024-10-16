<?php

namespace Database\Factories;

use App\Models\SaleDetail;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Database\Eloquent\Factories\Factory;

class SaleDetailFactory extends Factory
{
    protected $model = SaleDetail::class;

    public function definition()
    {
        return [
            'product_id' => Product::factory(),
            'sale_id' => Sale::factory(),
            'detail_quantity' => $this->faker->numberBetween(1, 20),
            'detail_unit_price_buy' => $this->faker->randomFloat(2, 10, 100),
            'detail_unit_price_sell' => $this->faker->randomFloat(2, 20, 200),
            'product_name' => $this->faker->word,
        ];
    }
}
