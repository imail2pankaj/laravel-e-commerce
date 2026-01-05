<?php

namespace App\Repositories;

use App\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;

class CategoryRepository implements CategoryRepositoryInterface
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
        return Category::all();
    }

    public function allQuery()
    {
        return Category::query();
    }

    public function find($id)
    {
        return Category::findOrFail($id);
    }

    public function create(array $data)
    {
        return Category::create($data);
    }

    public function update($id, array $data)
    {
        $Category = Category::findOrFail($id);
        $Category->update($data);
        return $Category;
    }

    public function delete($id)
    {
        $Category = Category::findOrFail($id);
        return $Category->delete();
    }
}
