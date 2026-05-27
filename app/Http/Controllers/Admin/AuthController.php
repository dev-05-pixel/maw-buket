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

            $firebaseError = $response->json()['error']['message'] ?? '';

            $message = match ($firebaseError) {
                'INVALID_LOGIN_CREDENTIALS' => 'Email atau password salah.',
                'EMAIL_NOT_FOUND' => 'Email tidak ditemukan.',
                'INVALID_PASSWORD' => 'Password yang Anda masukkan salah.',
                'USER_DISABLED' => 'Akun ini telah dinonaktifkan.',
                default => 'Email atau password tidak valid. Silakan coba lagi.',
            };

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

            $firebaseError = $response->json()['error']['message'] ?? '';

            $message = match ($firebaseError) {
                'EMAIL_NOT_FOUND' => 'Email tidak ditemukan.',
                'INVALID_EMAIL' => 'Format email tidak valid.',
                default => 'Gagal mengirim tautan reset password.',
            };

            return back()
                ->withInput()
                ->with('error', $message);
        }

        return back()
            ->with('success', 'Tautan reset password telah dikirim ke email Anda.')
            ->with('email', $request->email);
    }

    public function showResetForm(Request $request)
    {
        $oobCode = $request->query('oobCode');

        if (!$oobCode) {
            abort(404);
        }

        // Verifikasi token ke Firebase
        $apiKey = config('services.firebase.api_key');

        $response = Http::post(
            "https://identitytoolkit.googleapis.com/v1/accounts:resetPassword?key={$apiKey}",
            [
                'oobCode' => $oobCode,
            ]
        );

        if ($response->failed()) {
            abort(404);
        }

        return view('admin.auth.reset-password', [
            'oobCode' => $oobCode,
        ]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed',
            'oobCode' => 'required'
        ]);

        $apiKey = config('services.firebase.api_key');

        $response = Http::post(
            "https://identitytoolkit.googleapis.com/v1/accounts:resetPassword?key={$apiKey}",
            [
                'oobCode' => $request->oobCode,
                'newPassword' => $request->password,
            ]
        );

        if ($response->failed()) {
            return back()->with('error', 'Token reset tidak valid atau sudah kadaluarsa.');
        }

        return redirect('/admin/login')
            ->with('success', 'Password berhasil diperbarui. Silakan login.');
    }

    public function logout()
    {
        Session::flush();

        return redirect('/admin/login');
    }
}
