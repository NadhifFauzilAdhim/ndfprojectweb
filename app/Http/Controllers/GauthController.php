<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Carbon\Carbon;

class GauthController extends Controller
{
        /**
     * Redirect ke provider Google.
     */
    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Tangani callback dari provider Google tanpa verifikasi email.
     */
    public function handleProviderCallback(Request $request): RedirectResponse
    {
        $googleUser = Socialite::driver('google')->stateless()->user();
        $user = User::where('email', $googleUser->getEmail())->first();

        if ($user) {
            if (!$user->gauth_id) {
                $user->gauth_id = $googleUser->getId();
                $user->google_avatar = $googleUser->getAvatar();
                $user->gauth_type = 'google';
                $user->save();
            }
        } else {
            $user = User::create([
                'name'              => $googleUser->getName(),
                'username'          => $googleUser->getNickname() ?? explode('@', $googleUser->getEmail())[0],
                'email'             => $googleUser->getEmail(),
                'email_verified_at' => Carbon::now(),
                'gauth_id'          => $googleUser->getId(),
                'gauth_type'        => 'google',
                'password'          => bcrypt(Str::random(16)),
                'google_avatar'     => $googleUser->getAvatar(),
            ]);
        }

        Auth::login($user, true);
        return redirect()->intended('/dashboard');
    }
}
