<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class PaymentMethod
 * @package App\Models
 * @version August 31, 2024, 4:03 pm UTC
 *
 * @property string $name
 * @property string $observation
 */
class PaymentMethod extends Model
{
    use SoftDeletes;
    use HasFactory;


    public $table = 'payment_methods';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'observation'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'observation' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
