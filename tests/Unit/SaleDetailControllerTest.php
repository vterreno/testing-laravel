<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\SaleDetail;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SaleDetailControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_sale_details()
    {
        $this->withoutMiddleware();

        // Crear algunos detalles de venta
        SaleDetail::factory()->count(5)->create();

        $response = $this->get(route('sale_details.index'));

        $response->assertStatus(200)
                 ->assertJsonCount(5, 'data');
    }

    /** @test */
    public function it_can_create_a_sale_detail()
    {
        $this->withoutMiddleware();

        $product = Product::factory()->create();

        $data = [
            'product_id' => $product->id,
            'sale_id' => 1,
            'detail_quantity' => 10,
            'detail_unit_price_sell' => 100.00,
            'detail_unit_price_buy' => 80.00,
            'product_name' => 'Product Test',
        ];

        $response = $this->post(route('sale_details.store'), $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('sales_details', $data);
    }

    /** @test */
    public function it_can_update_a_sale_detail()
    {
        $this->withoutMiddleware();

        $saleDetail = SaleDetail::factory()->create();

        $updatedData = [
            'product_id' => $saleDetail->product_id,
            'detail_quantity' => 20,
            'detail_unit_price_sell' => 150.00,
            'detail_unit_price_buy' => 120.00,
            'product_name' => 'Updated Product Name',
        ];

        $response = $this->put(route('sale_details.update', $saleDetail->id), $updatedData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('sales_details', $updatedData);
    }

    /** @test */
    public function it_can_delete_a_sale_detail()
    {
        $this->withoutMiddleware();

        $saleDetail = SaleDetail::factory()->create();

        $response = $this->delete(route('sale_details.destroy', $saleDetail->id));

        $response->assertStatus(204);
        $this->assertDatabaseMissing('sales_details', ['id' => $saleDetail->id]);
    }

    /** @test */
    public function it_can_show_a_sale_detail()
    {
        $this->withoutMiddleware();

        $saleDetail = SaleDetail::factory()->create();

        $response = $this->get(route('sale_details.show', $saleDetail->id));

        $response->assertStatus(200)
                 ->assertJson([
                     'data' => [
                         'id' => $saleDetail->id,
                         'product_id' => $saleDetail->product_id,
                         'detail_quantity' => $saleDetail->detail_quantity,
                         'detail_unit_price_sell' => $saleDetail->detail_unit_price_sell,
                         'detail_unit_price_buy' => $saleDetail->detail_unit_price_buy,
                         'product_name' => $saleDetail->product_name,
                     ]
                 ]);
    }
}
