<?php

namespace Tests\Unit;

use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SaleControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_list_sales()
    {
        $this->withoutMiddleware();
        $payment_method = PaymentMethod::factory()->create();
        Sale::factory()->count(3)->create(['payment_method_id' => $payment_method->id]);
        $response = $this->get(route('sales.index'));
        $response->assertViewIs('sales.index');
    }

    public function it_can_display_the_create_sale_form()
    {
        $this->withoutMiddleware();
        $response = $this->get(route('sales.create'));

        $response->assertStatus(200);
        $response->assertViewIs('sales.create');
    }

    public function test_it_can_create_sales() {
        $this->withoutMiddleware();
        $payment_method = PaymentMethod::factory()->create();
        $products = Product::factory()->count(2)->create();
        $sale_details = [
            [
                'product_id' => $products[0]->id,
                'detail_quantity' => 2,
                'detail_unit_price_sell' => 100,
                'detail_unit_price_buy' => 50
            ],
            [
                'product_id' => $products[1]->id,
                'detail_quantity' => 3,
                'detail_unit_price_sell' => 200,
                'detail_unit_price_buy' => 100
            ]
        ];

        $data = [
            'payment_method_id' => $payment_method->id,
            'details_sales_json' => json_encode($sale_details)
        ];

        $response = $this->post(route('sales.store'), $data);
        $this->assertDatabaseHas('sales', [
            'payment_method_id' => $payment_method->id
        ]);
        $response->assertRedirect(route('sales.index'));
    }

    public function test_it_can_display_edit_sale_form() {
        $this->withoutMiddleware();
        $sale = Sale::factory()->create();
        $response = $this->get(route('sales.edit', $sale->id));
        $response->assertStatus(200);
        $response->assertViewIs('sales.edit');
    }

    public function test_it_can_update_sales() {
        $this->withoutMiddleware();
        $payment_method = PaymentMethod::factory()->create();
        $sale = Sale::factory()->create();
        $products = Product::factory()->count(2)->create();
        $sale_details = [
            [
                'product_id' => $products[0]->id,
                'detail_quantity' => 2,
                'detail_unit_price_sell' => 100,
                'detail_unit_price_buy' => 50
            ],
            [
                'product_id' => $products[1]->id,
                'detail_quantity' => 3,
                'detail_unit_price_sell' => 200,
                'detail_unit_price_buy' => 100
            ]
        ];

        $data = [
            'payment_method_id' => $payment_method->id,
            'details_sales_json' => json_encode($sale_details)
        ];

        $response = $this->put(route('sales.update', $sale->id), $data);
        $this->assertDatabaseHas('sales', [
            'payment_method_id' => $payment_method->id
        ]);
        $response->assertRedirect(route('sales.index'));
    }

    public function test_it_can_delete_sales() {
        $this->withoutMiddleware();
        $sale = Sale::factory()->create();
        $response = $this->delete(route('sales.destroy', $sale->id));
        $this->assertSoftDeleted('sales', ['id' => $sale->id]);
        $response->assertRedirect(route('sales.index'));
    }
}
