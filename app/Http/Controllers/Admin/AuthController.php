<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use App\Models\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $apiKey = config('services.firebase.api_key');

        $response = Http::post(
            "https://identitytoolkit.googleapis.com/v1/accounts:signInWithPassword?key={$apiKey}",
            [
                'email' => $request->email,
                'password' => $request->password,
                'returnSecureToken' => true,
            ]
        );

        if ($response->failed()) {

            $message = $response->json()['error']['message']
                ?? 'Email atau password tidak valid. Silakan coba lagi.';

            return back()
                ->withInput($request->only('email'))
                ->with('error', $message);
        }

        $data = $response->json();

        $admin = Admin::where('uid', $data['localId'])->first();

        if (!$admin) {
            return back()->with('error', 'Anda bukan administrator.');
        }

        Session::put('admin_uid', $admin->uid);
        Session::put('admin_email', $admin->email);

        return redirect('/admin/dashboard');
    }

    public function showForgotPasswordForm()
    {
        return view('admin.auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $apiKey = config('services.firebase.api_key');

        $response = Http::post(
            "https://identitytoolkit.googleapis.com/v1/accounts:sendOobCode?key={$apiKey}",
            [
                'requestType' => 'PASSWORD_RESET',
                'email' => $request->email,
            ]
        );

        if ($response->failed()) {

            $data = $response->json();

            $message = $data['error']['message']
                ?? 'Email tidak ditemukan dalam sistem kami.';

            return back()
                ->withInput()
                ->with('error', $message);
        }

        return back()
            ->with('success', 'Tautan reset password telah dikirim ke email Anda.')
            ->with('email', $request->email);
    }

    public function logout()
    {
        Session::flush();

        return redirect('/admin/login');
    }
}
