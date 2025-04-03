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
            'users' => User::orderBy('id', 'desc')->paginate(20)->withQueryString(),
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
            } elseif(!$user->email_verified_at && $user->id != Auth::id()) {
                $user->update(['email_verified_at' => now()]);
                Notification::send($user, new UserVerified());
                return redirect()->back()->with('success', 'User verified successfully.');
            }
            elseif($user->id == Auth::id()) {
                return redirect()->back()->with('error', 'You cannot unverify yourself.');
            }
            else{
                return redirect()->back()->with('error', 'Failed to verify user.');
            }
        }
        return abort(403);
    }

    public function exportCSV()
    {
        $dateTime = now()->format('Y-m-d H:i:s');
        $fileName = 'user_emails '.$dateTime.'.csv';
        $users = User::all(['id', 'name','username','email']);

        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $columns = ['ID', 'Name','Username', 'Email'];

        $callback = function() use ($users, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            foreach ($users as $user) {
                fputcsv($file, [$user->id, $user->name, $user->username ,$user->email]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

}
