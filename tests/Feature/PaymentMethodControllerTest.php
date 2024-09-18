<?php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Log;

class PaymentMethodControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_list_payment_methods()
    {
        $this->withoutMiddleware();
        PaymentMethod::factory()->count(3)->create();
        $response = $this->get(route('payment_methods.index'));
        // Log::info(json_encode($response->content()));
        $response->assertViewIs('payment_methods.index');
    }

    public function test_it_can_create_a_payment_method()
    {
        $this->withoutMiddleware();
        $data = [
            'name' => 'Tarjeta de Crédito',
            'observation' => 'active'
        ];

        $response = $this->post(route('payment_methods.store'), $data);
        // Log::info(json_encode($response->content()));
        $response->assertRedirect('payment_methods');
        
        $this->assertDatabaseHas('payment_methods', [
            'name' => 'Tarjeta de Crédito',
            'observation' => 'active'
        ]);
    }

}
