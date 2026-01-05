<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
   protected $fillable = [
        'product_id',
        'sku',
        'original_price',
        'selling_price',
        'stock',
        'image',
        'is_default',
        'status',
        'is_invalid',
        'invalid_reason',
        'sort_order',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function values()
    {
        return $this->hasMany(ProductVariantValue::class, 'product_variant_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

}


