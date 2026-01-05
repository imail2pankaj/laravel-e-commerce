<?php

namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;

class ProductRepository implements ProductRepositoryInterface
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
        return Product::all();
    }

    public function allQuery()
    {
        return Product::query();
    }

    public function find($id)
    {
        return Product::findOrFail($id);
    }


    public function create(array $data)
    {
        return Product::create($data);
    }

    public function update($id, array $data)
    {
        $product = Product::findOrFail($id);
        $product->update($data);
        return $product;
    }

    public function delete($id)
    {
        $Product = Product::findOrFail($id);
        return $Product->delete();
    }
}
