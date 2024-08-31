<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class Sale
 * @package App\Models
 * @version August 31, 2024, 4:30 pm UTC
 *
 */
class Sale extends Model
{
    use SoftDeletes;


    public $table = 'sales';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'payment_method_id',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'payment_method_id' => 'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    public function payment_method()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    
}
