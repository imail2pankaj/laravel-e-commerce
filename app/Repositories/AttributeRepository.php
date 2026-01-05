<?php

namespace App\Repositories;

use App\Interfaces\AttributeRepositoryInterface;
use App\Models\Attribute;

class AttributeRepository implements AttributeRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

     public function all()
    {
        return Attribute::all();
    }

    public function allQuery()
    {
        return Attribute::query();
    }

    public function find($id)
    {
        return Attribute::findOrFail($id);
    }

    public function create(array $data)
    {
        return Attribute::create($data);
    }

    public function update($id, array $data)
    {
        $attribute = Attribute::findOrFail($id);
        $attribute->update($data);
        return $attribute;
    }

    public function delete($id)
    {
        $attribute = Attribute::findOrFail($id);
        return $attribute->delete();
    }
}
