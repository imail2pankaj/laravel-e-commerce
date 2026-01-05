<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CouponCategory extends Model
{
    protected $fillable = ['coupon_id', 'category_id'];

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
