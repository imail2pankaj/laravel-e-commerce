<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
     protected $fillable = [
        'category_id',
        'brand_id',
        'name',
        'slug',
        'sku', 
        'short_description',
        'description',
        'main_image',
        'original_price',
        'selling_price',
        'stock',
        'status',
        'is_active',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $with = [
        'category',
        'brand',
        'attributes',
        'attributeValues',
        'images',
        'tags',
        'variants',
        'coupons',
    ];


    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
        
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'product_attributes')
                    ->withTimestamps();
    }

    public function attributeValues()
    {
        return $this->belongsToMany(AttributeValue::class, 'product_attribute_values');
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function coupons()
    {
        return $this->hasMany(CouponProduct::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }


}
