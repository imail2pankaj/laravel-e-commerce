<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'name',
        'discount_type',
        'discount_value',
        'max_discount',
        'min_order_amount',
        'apply_type',
        'usage_limit',
        'usage_limit_per_user',
        'start_date',
        'end_date',
        'status',
        'created_by'
    ];

    public function products()
    {
        return $this->hasMany(CouponProduct::class);
    }

    public function categories()
    {
        return $this->hasMany(CouponCategory::class);
    }

    public function brands()
    {
        return $this->hasMany(CouponBrand::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

}

