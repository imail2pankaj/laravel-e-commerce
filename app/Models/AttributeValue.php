<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    protected $table = 'attribute_values';

    protected $fillable = [
        'attribute_id',
        'value',
        'slug',
        'sort_order',
        'is_active',
    ];

    /**
     * Parent attribute (Color, RAM, Storage)
     */
    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }
}
