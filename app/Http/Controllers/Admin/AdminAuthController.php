<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLoginRequest;
use App\Interfaces\AdminAuthRepositoryInterface;
use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
     protected $adminAuthRepo;

    public function __construct(AdminAuthRepositoryInterface $adminAuthRepo)
    {
        $this->adminAuthRepo = $adminAuthRepo;
    }

    public function loginPage()
    {
        return view('admin.auth.login');
    }
    public function login(AdminLoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        $success = $this->adminAuthRepo->login($credentials);

        if ($success) {
            return redirect()->route('admin.users.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid email or password']);
    }

    public function logout()
    {
        $this->adminAuthRepo->logout();

        return redirect()->route('admin.login');
    }

}
