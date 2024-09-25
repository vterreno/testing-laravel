<?php

namespace Tests\Unit;

use App\Models\PaymentMethod;
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
        $data = [
            'payment_method_id' => $payment_method->id
        ];

        $response = $this->post(route('sales.store'), $data);
        $this->assertDatabaseHas('sales', [
            'payment_method_id' => $payment_method->id
        ]);
        $response->assertRedirect(route('sales.index'));
    }
}
