<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        return "Proses login";
    }

    public function showForgotPasswordForm()
    {
        return view('admin.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        return "Kirim reset link";
    }

    public function logout()
    {
        return "Logout berhasil";
    }
}
