<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderAddress extends Model
{
    protected $fillable = [
        'order_id',
        'type',
        'name',
        'phone',
        'email',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'postal_code',
        'country',
    ];

    /*
    |--------------------------------------------------------------------------
    | ConstantsOrder
    |--------------------------------------------------------------------------
    */
    const TYPE_SHIPPING = 'shipping';
    const TYPE_BILLING  = 'billing';

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
