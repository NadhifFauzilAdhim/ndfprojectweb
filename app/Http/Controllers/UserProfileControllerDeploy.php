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
            'image' => 'required|image|max:4096', 
        ]);

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            try {
                $file = $request->file('image');

                $originalExtension = strtolower($file->getClientOriginalExtension());
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

                if (!in_array($originalExtension, $allowedExtensions)) {
                    return redirect()->back()->with('error', 'Ekstensi file tidak valid. Hanya file .jpg, .jpeg, .png, dan .gif yang diizinkan.');
                }

                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mimeType = finfo_file($finfo, $file->getPathname());
                finfo_close($finfo);

                $allowedMimeTypes = [
                    'image/jpeg' => 'jpg',
                    'image/png' => 'png',
                    'image/gif' => 'gif',
                ];

                if (!array_key_exists($mimeType, $allowedMimeTypes)) {
                    return redirect()->back()->with('error', 'Tipe file tidak valid. Hanya gambar JPEG, PNG, dan GIF yang diizinkan.');
                }

                $safeExtension = $allowedMimeTypes[$mimeType];
                $imageName = uniqid() . '.' . $safeExtension; 

                $destinationPath = base_path('../public/avatars');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                if ($user->avatar && file_exists(base_path('../public/' . $user->avatar))) {
                    unlink(base_path('../public/' . $user->avatar));
                }

                $temporaryFilePath = $destinationPath . '/' . $imageName; 
                $file->move($destinationPath, $imageName);

                try {
                    $imgManager = new ImageManager(new Driver);
                    $filteredImage = $imgManager->read($temporaryFilePath); 
                    $filteredImage->resize(500, 500);

                    if ($safeExtension === 'jpg' || $safeExtension === 'jpeg') {
                        $filteredImage->toJpeg(80)->save($temporaryFilePath);
                    } elseif ($safeExtension === 'png') {
                        $filteredImage->toPng()->save($temporaryFilePath);
                    } elseif ($safeExtension === 'gif') {
                        $filteredImage->toGif()->save($temporaryFilePath);
                    } else {
                        $filteredImage->save($temporaryFilePath, 80);
                    }

                } catch (\Exception $e) {
                    if (file_exists($temporaryFilePath)) {
                        unlink($temporaryFilePath); 
                    }
                    return redirect()->back()->with('error', 'File yang diunggah bukan gambar yang valid atau rusak setelah pemeriksaan lebih lanjut.');
                }

                $imagePath = 'avatars/' . $imageName;
                $user->avatar = $imagePath;
                $user->save();

                return redirect('/dashboard/profile')->with('success', 'Gambar profil berhasil diperbarui.');

            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses gambar: ' . $e->getMessage());
            }
        } else {
            return redirect()->back()->with('error', 'File tidak diunggah atau tidak valid.');
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
