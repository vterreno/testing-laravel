<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;


/**
 * Class Product
 * @package App\Models
 * @version August 28, 2024, 5:59 pm UTC
 *
 * @property string $name
 * @property number $unit_price_sell
 * @property number $unit_price_buy
 * @property string $description
 */
class Product extends Model
{
    use HasFactory, SoftDeletes;


    public $table = 'products';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'unit_price_sell',
        'unit_price_buy',
        'description',
        'product_category_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'unit_price_sell' => 'float',
        'unit_price_buy' => 'float',
        'description' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    public function product_category()
    {
        return $this->belongsTo(ProductCategory::class);
    }
}
