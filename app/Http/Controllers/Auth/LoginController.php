<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Notifications\UserLogin;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Notification;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login', [
            'title' => 'Login'
        ]);
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required',
            'cf-turnstile-response' => ['required', Rule::turnstile()]
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            $user = Auth::user();
            $ip_address = $request->ip();
            $login_time = now()->format('Y-m-d H:i:s');
            $browser = $request->header('User-Agent');
            Notification::send($user,new UserLogin($ip_address, $login_time, $browser));
            return redirect()->back();
        }

        return back()->withErrors([
            'loginfeedback' => 'Email dan Password salah',
        ])->onlyInput('email');
    }

    public function deauthenticate(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }


}
