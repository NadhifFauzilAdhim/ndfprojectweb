<?php

namespace App\Http\Controllers;

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
        User::where('id', $user->id)->update($validatedData);
        $user->update(['profile_updated_at' => now()]);

        return redirect('/dashboard/profile')->with('success', 'Profile Diperbarui');
    }

    public function changeProfileImage(Request $request, User $user)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            try {
                $file = $request->file('image');
                $imageName = uniqid() . '.' . $file->getClientOriginalExtension();
                $destinationPath = base_path('../public/avatars');

                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true); 
                }

                if ($user->avatar && file_exists(base_path('../public/' . $user->avatar))) {
                    unlink(base_path('../public/' . $user->avatar)); // Hapus file sebelumnya
                }

                // Pindahkan file ke lokasi sementara
                $tempPath = $file->move($destinationPath, $imageName);

                // Resize gambar menggunakan Intervention Image
                $fullPath = $destinationPath . '/' . $imageName; // Path lengkap file
                $imgManager = new ImageManager(new Driver);
                $filteredImage = $imgManager->read($fullPath);
                $filteredImage->resize(500, 500)->save($fullPath); // Resize dan simpan ulang

                // Simpan path relatif di database
                $imagePath = 'avatars/' . $imageName;
                $user->avatar = $imagePath;
                $user->save();

                return redirect('/dashboard/profile')->with('success', 'Profile image updated successfully.');
            } catch (\Exception $e) {
                return redirect()->back()->withErrors('Error processing image: ' . $e->getMessage());
            }
        } else {
            return redirect()->back()->withErrors('File not uploaded or invalid.');
        }
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
