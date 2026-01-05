<?php

namespace App\Repositories;

use App\Interfaces\CouponRepositoryInterface;
use App\Models\Coupon;

class CouponRepository implements CouponRepositoryInterface
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
        return Coupon::all();
    }

    public function allQuery()
    {
        return Coupon::query();
    }

    public function find($id)
    {
        return Coupon::findOrFail($id);
    }

    public function create(array $data)
    {
        return Coupon::create($data);
    }

    public function update($id, array $data)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->update($data);
        return $coupon;
    }

    public function delete($id)
    {
        $coupon = Coupon::findOrFail($id);
        return $coupon->delete();
    }
}
