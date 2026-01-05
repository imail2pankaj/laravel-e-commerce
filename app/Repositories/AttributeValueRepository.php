<?php

namespace App\Repositories;

use App\Interfaces\AttributeValueRepositoryInterface;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Support\Str;

class AttributeValueRepository implements AttributeValueRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function all()
    {
        return AttributeValue::all();
    }

    public function allQuery()
    {
        return AttributeValue::query();
    }



    public function getActiveAttributes()
    {
        return Attribute::where('is_active', 1)->get();
    }

    public function getActiveAttributesWithValues()
    {
        return Attribute::with(['values' => function ($q) {
                $q->orderBy('sort_order');
            }])
            ->where('is_active', 1)
            ->get();
    }

    public function find($id)
    {
        return AttributeValue::findOrFail($id);
    }

    public function create(array $data)
    {
        return AttributeValue::create($data);
    }

    public function update($id, array $data)
    {
        return AttributeValue::where('id', $id)->update($data);
    }

    public function delete($id)
    {
        return AttributeValue::where('id', $id)->delete();
    }

    public function getMaxSortOrder(int $attributeId): int
    {
        return AttributeValue::where('attribute_id', $attributeId)
            ->max('sort_order') ?? 0;
    }
}

