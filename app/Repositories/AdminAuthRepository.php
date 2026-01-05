<?php

namespace App\Repositories;

use App\Interfaces\AdminAuthRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class AdminAuthRepository implements AdminAuthRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function login(array $credentials)
    {
       if (Auth::guard('admin')->attempt($credentials)) {
            return true;
        }

        return false;
    }
    public function logout()
    {
         Auth::guard('admin')->logout();
    }
}
