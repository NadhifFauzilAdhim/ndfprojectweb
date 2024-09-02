<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class UserProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.profile.index', [
            'title' => 'Profile',
            'user' => Auth::user()
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        
        $datarules = ([
            'name' => 'required|max:255'
        ]);
    
        if ($request->username != $user->username) {
            $datarules['username'] = 'required|unique:users';
        }
        
       $validatedData = $request->validate($datarules);
        User::where('id', $user->id)->update($validatedData);
        return redirect('/dashboard/profile')->with('success', 'Profile Berhasil Diperbarui');
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
            $imagePath = $request->file('image')->store('profile_images');
            $imgManager = new ImageManager(new Driver);
            $filteredImage = $imgManager->read('storage/'.$imagePath);
            $filteredImage->resize(500,500)->save('storage/'.$imagePath);
            $user->avatar = $imagePath;
            $user->save();
        }
        return redirect('/dashboard/profile')->with('success', 'Profile image updated successfully.');
    }

    // public function changeImage(Request $request, User $user)
    // {
    //     // Validasi input file
    //     $request->validate([
    //         'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    //     ]);
    //     if ($request->file('image')) {
    //         if ($user->avatar) {  
    //             Storage::delete($user->avatar);
    //         }
    //         $imagePath = $request->file('image')->store('profile_images');
    //         $user->avatar = $imagePath;
    //         $user->save();
    //     }
    //     return redirect('/dashboard/profile')->with('success', 'Profile image updated successfully.');
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
