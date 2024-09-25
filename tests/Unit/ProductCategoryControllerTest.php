<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductCategoryControllerTest extends TestCase
{
    public function test_it_can_list_product_categories()
    {
        $this->withoutMiddleware();
        ProductCategory::factory()->count(3)->create();
        $response = $this->get(route('product_categories.index'));
        // Log::info(json_encode($response->content()));
        $response->assertViewIs('product_categories.index');
    }

    public function test_it_can_create_a_product_category()
    {
        $this->withoutMiddleware();
        $data = [
            'name' => 'Salados',
            'description' => 'categoria de productos salados'
        ];

        $response = $this->post(route('product_categories.store'), $data);
        // Log::info(json_encode($response->content()));
        $response->assertRedirect('product_categories');
        
        $this->assertDatabaseHas('product_categories', [
            'name' => 'Salados',
            'description' => 'categoria de productos salados'
        ]);
    }

    public function test_it_can_modify_a_product_category() {
        $this->withoutMiddleware();
        $product_category = ProductCategory::factory()->create();
        $data = [
            'name' => 'Salados',
            'description' => 'categoria de productos'
        ];

        $response = $this->put(route('product_categories.update', $product_category->id), $data);

        $response->assertRedirect('product_categories');
        $this->assertDatabaseHas('product_categories', [
            'name' => 'Salados',
            'description' => 'categoria de productos'
        ]);
    }

    public function test_it_can_delete_a_product_category() {
        $this->withoutMiddleware();
        $product_category = ProductCategory::factory()->create();
        $response = $this->delete(route('product_categories.destroy', $product_category->id));
        $response->assertRedirect('product_categories');
        $this->assertDatabaseMissing('product_categories', [
            'deleted_at' => !null
        ]);
    }
}
