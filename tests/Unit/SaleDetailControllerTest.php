<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\SaleDetail;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SaleDetailControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_sale_details()
    {   
        $this->withoutMiddleware();
        // Crear 5 SaleDetail
        SaleDetail::factory()->count(5)->create();

        // Realizar la petición a la ruta de listado.
        $response = $this->get('/listar-sales-detail');

        // Verificar que el estatus de la respuesta sea 200 y que haya 5 registros en la respuesta.
        $response->assertJsonCount(5, 'data');
    }

    /** @test */
    public function it_can_update_a_sale_detail()
    {
        $this->withoutMiddleware();
        $saleDetail = SaleDetail::factory()->create();

        $updatedData = [
            'id' => $saleDetail->id,
            'product_id' => $saleDetail->product_id,
            'product_name' => $saleDetail->product_name,
            'detail_quantity' => 15,
            'detail_unit_price_sell' => 150.0,
            'detail_unit_price_buy' => 120.0,
        ];

        // Realizar la petición PUT a la ruta de actualización.
        $response = $this->putJson(route('actualizar-sale-detail'), $updatedData);

        // Verificar que la respuesta sea 200 y que los datos actualizados estén en la base de datos.
        $this->assertDatabaseHas('sales_details', $updatedData);
    }

    /** @test */
    public function it_can_delete_a_sale_detail()
{
    $this->withoutMiddleware();
    $saleDetail = SaleDetail::factory()->create();

    // Realizar la petición DELETE a la ruta de eliminación.
    $response = $this->delete(route('borrar-sales-detail', ['id' => $saleDetail->id]));
    $this->assertSoftDeleted('sales_details', ['id' => $saleDetail->id]);
}

    /** @test */
    public function it_can_list_product() {
        $this->withoutMiddleware();
        $product = Product::factory()->create();

        $response = $this->get(route('obtener-producto', ['id' => $product->id]));

        $response->assertJson(['product' => $product->toArray()]);
    }
}