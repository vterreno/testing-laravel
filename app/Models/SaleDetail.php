<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes;
class SaleDetail extends Model
{
     use SoftDeletes;    public $table = 'sales_details';

    public $fillable = [
        'product_id',
        'sale_id',
        'detail_quantity',
        'observation',
        'detail_unit_price_buy',
        'detail_unit_price_sell',
        'product_name',
    ];

    protected $casts = [
        'id' => 'integer',
        'product_id' => 'integer',
        'sale_id' => 'integer',
        'observation' => 'string',
        'detail_quantity' => 'integer',
        'detail_unit_price_buy' => 'float',
        'detail_unit_price_sell' => 'float',
        'product_name' => 'string',
    ];

    public static array $rules = [
        
    ];
    
}
