<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Symfony\Component\VarDumper\VarDumper;
use Symfony\Contracts\Service\Attribute\Required;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register',[
            'title' => 'Register'
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|min:3',
            'username' => 'required|min:3|max:255|unique:users|regex:/^\S*$/u',
            'email' => 'required|email:dns|unique:users|usercheck:block_disposable',
            'password' => 'required|min:5|max:255',
            'cf-turnstile-response' => ['required', Rule::turnstile()]

        ]);

        $validatedData = $request->only('name', 'username', 'email', 'password');
    
        try {
            $user = User::create($validatedData);
            event(new Registered($user));
            Auth::login($user);
    
            return redirect('/email/verify')->with('success', 'Verify email first');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to send verification email. SERVER ERROR.');
        }
    }
    

    public function verifyemail()
    { 

        if(Auth::user()->email_verified_at !== null){
            return redirect('/email/verify-success');
        }
        return view('auth.verify-email', [
            'title' => 'Verify Email'
        ]);
    }

    public function emailVerificationRequest(EmailVerificationRequest $request){
        $request->fulfill();
        return redirect('/email/verify-success');
    }

  
    public function verificationResend(Request $request)
    {
        if (Auth::user()->email_verified_at !== null) {
            return redirect('/');
        }

        try {
            $request->user()->sendEmailVerificationNotification();
            return back()->with('resendsuccess', 'Email verifikasi telah dikirim ulang. Silakan cek email Anda.');
        } catch (\Exception $e) {
            return back()->with('resenderror', 'Gagal mengirim ulang email verifikasi. Silakan coba lagi nanti. SERVER ERROR');
        }
    }


    public function verificationSuccess(){
        return view('auth.verify-success', [
            'title' => 'Email Verification Success'
        ]);
    }
       
}
