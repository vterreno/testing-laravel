<?php

use App\Models\PaymentMethod;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDefaultPaymentMethods extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $payment_methods = [
            [
                'name' => 'Efectivo',
                'observation' => 'Pago en efectivo'
            ], [
                'name' => 'Tarjeta de crédito',
                'observation' => 'Pago con tarjeta de crédito'
            ], [
                'name' => 'Tarjeta de débito',
                'observation' => 'Pago con tarjeta de débito'
            ], [
                'name' => 'Transferencia bancaria',
                'observation' => 'Pago por transferencia bancaria'
            ], [
                'name' => 'Cheque',
                'observation' => 'Pago con cheque'
            ]
        ];

        foreach ($payment_methods as $payment_method) {
            PaymentMethod::create($payment_method);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
}
