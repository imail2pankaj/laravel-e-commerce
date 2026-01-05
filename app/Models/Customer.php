<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
     protected $fillable = [
        'name',
        'phone',
        'email',
        'password',
        'status',
        'notes',
        'created_by',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

}
