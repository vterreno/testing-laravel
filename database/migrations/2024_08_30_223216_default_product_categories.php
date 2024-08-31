<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DefaultProductCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $product_categories = [
            [
                'name' => 'Salados',
                'description' => 'Productos salados',
            ], [
                'name' => 'Dulces',
                'description' => 'Productos dulces',
            ], [
                'name' => 'Bebidas',
                'description' => 'Bebidas',
            ], [
                'name' => 'Otros',
                'description' => 'Otros productos',
            ]
        ];

        foreach ($product_categories as $product_category) {
            \App\Models\ProductCategory::create($product_category);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach (\App\Models\ProductCategory::all() as $product_category) {
            $product_category->delete();
        }
    }
}
