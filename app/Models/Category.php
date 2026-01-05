<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
  
    protected $fillable = [
        'name',
        'slug',
        'image',
        'description',
        'status',
        'is_featured',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    // Cast values
    protected $casts = [
        'is_featured' => 'boolean',
    ];
    

    public function coupons()
    {
        return $this->hasMany(CouponCategory::class);
    }

}
