<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\UserVerified;
use Illuminate\Support\Facades\Notification;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.adminuser', [
            'title' => 'User Setting',
            'users' => User::all()
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        if (Auth::user()->is_owner) {
            if ($user->email_verified_at && $user->id != Auth::id()) {
                $user->update(['email_verified_at' => null]);
                return redirect()->back()->with('success', 'User unverified successfully.');
            } else {
                $user->update(['email_verified_at' => now()]);
                Notification::send($user, new UserVerified());
                return redirect()->back()->with('success', 'User verified successfully.');
            }
        }
        return abort(403);
    }
}
