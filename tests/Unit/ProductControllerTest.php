<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_display_the_product_list()
    {
        $this->withoutMiddleware();
        // Creamos una categoría de producto
        $category = ProductCategory::factory()->create();

        // Creamos algunos productos en la base de datos
        Product::factory()->count(3)->create(['product_category_id' => $category->id]);

        // Hacemos una solicitud GET a la ruta index
        $response = $this->get(route('products.index'));

        // Aseguramos que la respuesta es correcta (200 OK)
        $response->assertStatus(200);

        // Verificamos que los productos se muestran en la vista
        $response->assertViewHas('products');
    }

    /** @test */
    public function it_can_display_the_create_product_form()
    {
        $this->withoutMiddleware();
        $response = $this->get(route('products.create'));

        $response->assertStatus(200);
        $response->assertViewIs('products.create');
    }

    /** @test */
    public function it_can_store_a_new_product()
    {
        $this->withoutMiddleware();
        // Creamos una categoría de producto
        $category = ProductCategory::factory()->create();

        // Simulamos los datos del producto
        $data = [
            'name' => 'Nuevo Producto',
            'unit_price_sell' => 100,
            'unit_price_buy' => 50,
            'description' => 'Descripción del producto',
            'product_category_id' => $category->id,
        ];

        // Hacemos una solicitud POST a la ruta store con los datos simulados
        $response = $this->post(route('products.store'), $data);

        // Aseguramos que el producto fue creado en la base de datos
        $this->assertDatabaseHas('products', ['name' => 'Nuevo Producto']);

        // Aseguramos que la redirección fue correcta
        $response->assertRedirect(route('products.index'));
    }

    /** @test */
    public function it_can_update_an_existing_product()
    {
        $this->withoutMiddleware();
        // Creamos una categoría de producto
        $category = ProductCategory::factory()->create();

        // Creamos un producto
        $product = Product::factory()->create(['product_category_id' => $category->id]);

        // Datos actualizados
        $data = [
            'name' => 'Producto Actualizado',
            'unit_price_sell' => 150,
            'unit_price_buy' => 75,
            'description' => 'Descripción actualizada',
            'product_category_id' => $category->id,
        ];

        // Hacemos una solicitud PUT a la ruta update con los datos actualizados
        $response = $this->put(route('products.update', $product->id), $data);

        // Aseguramos que los cambios se guardaron en la base de datos
        $this->assertDatabaseHas('products', ['name' => 'Producto Actualizado']);

        // Aseguramos que la redirección fue correcta
        $response->assertRedirect(route('products.index'));
    }

    /** @test */
    public function it_can_delete_a_product()
    {
        $this->withoutMiddleware();
        // Creamos un producto
        $product = Product::factory()->create();

        // Hacemos una solicitud DELETE a la ruta destroy
        $response = $this->delete(route('products.destroy', $product->id));

        // Verificamos que el producto ha sido eliminado
        $this->assertSoftDeleted('products', ['id' => $product->id]);

        // Aseguramos que la redirección fue correcta
        $response->assertRedirect(route('products.index'));
    }
}
