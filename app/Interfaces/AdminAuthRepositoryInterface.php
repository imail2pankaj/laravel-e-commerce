<?php

namespace App\Interfaces;

interface AdminAuthRepositoryInterface
{
    public function login(array $credentials);
    public function logout();
}
