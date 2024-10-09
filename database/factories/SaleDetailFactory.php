<?php

namespace Database\Factories;

use App\Models\SaleDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

class SaleDetailFactory extends Factory
{
    protected $model = SaleDetail::class;

    public function definition()
    {
        return [
            'product_id' => $this->faker->numberBetween(1, 100),
            'sale_id' => $this->faker->numberBetween(1, 100),
            'detail_quantity' => $this->faker->numberBetween(1, 20),
            'observation' => $this->faker->sentence,
            'detail_unit_price_buy' => $this->faker->randomFloat(2, 10, 100),
            'detail_unit_price_sell' => $this->faker->randomFloat(2, 20, 200),
            'product_name' => $this->faker->word,
        ];
    }
}
