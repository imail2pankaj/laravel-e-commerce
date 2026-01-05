<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'customer_id',

        'subtotal',
        'tax_amount',
        'shipping_amount',
        'discount_amount',
        'grand_total',

        'coupon_id',
        'coupon_code',

        'order_status',
        'payment_status',
        'payment_method',
        'shipping_method',

        'notes',
    ];



    // Customer who placed the order
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Applied coupon (if any)
    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function addresses()
    {
        return $this->hasMany(OrderAddress::class);
    }

    public function shippingAddress()
    {
        return $this->hasOne(OrderAddress::class)
            ->where('type', OrderAddress::TYPE_SHIPPING);
    }

    public function billingAddress()
    {
        return $this->hasOne(OrderAddress::class)
            ->where('type', OrderAddress::TYPE_BILLING);
    }



}
