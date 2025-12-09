<?php

namespace App\Http\Controllers\UserManagement;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Log;


class UserProfileController extends Controller
{
    public function index()
    {
        return view('dashboard.profile.index', [
            'title' => 'Profile',
            'user' => Auth::user()
        ]);
    }
   
    public function update(Request $request, User $user)
    {
        $lastUpdated = $user->updated_at;
        if($request->name == $user->name && $request->username == $user->username) {
            return redirect('/dashboard/profile')->with('error', 'Tidak ada perubahan yang dilakukan');
        }
        if ($lastUpdated && $lastUpdated->diffInMinutes(now()) < 10) {
            $remainingSeconds = 600 - $lastUpdated->diffInSeconds(now()); 
            $remainingMinutes = floor($remainingSeconds / 60);
            $remainingSeconds = $remainingSeconds % 60;
            return redirect('/dashboard/profile')
                ->with('error', "Profil dapat diubah setelah $remainingMinutes menit dan $remainingSeconds detik.");
        }
        $datarules = [
            'name' => 'required|max:255',
        ];

        if ($request->username != $user->username) {
            $datarules['username'] = [
                'required', 
                'unique:users', 
                'regex:/^\S*$/', 
                'not_regex:/<[^>]*>/' 
            ];
        }
        
        $validatedData = $request->validate($datarules);

        // Update data user
        User::where('id', $user->id)->update($validatedData);

        // Update profile_updated_at
        $user->update(['profile_updated_at' => now()]);

        return redirect('/dashboard/profile')->with('success', 'Profile Diperbarui');
    }

    public function changeProfileImage(Request $request, User $user)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if ($request->file('image')) {
            if ($user->avatar) {  
                  Storage::delete($user->avatar);
            }
            $imagePath = $request->file('image')->store('avatar');
            $imgManager = new ImageManager(new Driver);
            $filteredImage = $imgManager->read('storage/'.$imagePath);
            $watermarkPath = public_path('img/watermark.png');
            
            $filteredImage->resize(500,500)->place($watermarkPath, 'bottom-right', 10, 10)->save('storage/'.$imagePath);
            $user->avatar = $imagePath;
            $user->save();
        }
        return redirect('/dashboard/profile')->with('success', 'Profile image updated successfully.');
    }  

    public function changePassword()
    {
        $user = Auth::user();
        $token = Str::random(60);
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            [
                'token' => $token,
                'created_at' => now(),
            ]
        );
        Mail::send('emails.password_reset_confirmation', ['token' => $token, 'user' => $user], function ($message) use ($user) {
            $message->to($user->email);
            $message->subject('Link Konfirmasi Perubahan Password');
        });
        return redirect('/dashboard/profile')->with('success', 'Link untuk mengganti password telah dikirimkan ke email Anda');
    }


    public function showResetPasswordForm(Request $request)
    {
        $token = $request->query('token');
        $tokenData = DB::table('password_reset_tokens')->where('token', $token)->first();
        if ($tokenData && Carbon::parse($tokenData->created_at)->addMinutes(60)->isPast()) {
            return redirect('/dashboard/profile')->withErrors(['token' => 'Token sudah kadaluarsa.']);
        }
        return view('dashboard.profile.reset-password', [
            'title' => 'Reset Password',
            'token' => $token,
            'user' => Auth::user()
        ]);
    }


    public function updatePassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'new_password' => ['required', 'string', 'min:8'],
            'password_confirmation' => 'required'
        ]);
        if ($request->new_password != $request->password_confirmation) {
            return back()->withErrors(['password_confirmation' => 'Password baru dan Konfirmasi tidak sama']);
        }
        $tokenData = DB::table('password_reset_tokens')->where('token', $request->token)->first();
        if (!$tokenData) {
            return redirect('/dashboard/profile')->withErrors(['token' => 'Token tidak valid atau sudah kadaluarsa']);
        }
        $user = User::where('email', $tokenData->email)->first();
        if (!$user) {
            return redirect('/dashboard/profile')->withErrors(['email' => 'Pengguna tidak ditemukan']);
        }
        $user->password = Hash::make($request->new_password);
        $user->save();
        DB::table('password_reset_tokens')->where('email', $user->email)->delete();
        Log::info('Password updated for user id: ' . $user->id);
        return redirect('/dashboard/profile')->with('success', 'Password Anda telah berhasil diperbarui');
    }
    
    
}
