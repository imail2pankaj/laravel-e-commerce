<?php

namespace App\Repositories;

use App\Interfaces\AdminRepositoryInterface;
use App\Models\Admin;

class AdminRepository implements AdminRepositoryInterface
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
        return Admin::all();
    }

    public function allQuery()
    {
        return Admin::query();
    }

    public function find($id)
    {
        return Admin::findOrFail($id);
    }

    public function create(array $data)
    {
        return Admin::create($data);
    }

    public function update($id, array $data)
    {
        $Admin = Admin::findOrFail($id);
        $Admin->update($data);
        return $Admin;
    }

    public function delete($id)
    {
        $Admin = Admin::findOrFail($id);
        return $Admin->delete();
    }
}
