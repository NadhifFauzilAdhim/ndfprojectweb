<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\VarDumper\VarDumper;
use Symfony\Contracts\Service\Attribute\Required;

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
        $validatedData = $request->validate([
            'name' => 'required|max:255|min:3',
            'username' => 'required|min:3|max:255|unique:users|regex:/^\S*$/u',
            'email' => 'required|email:dns|unique:users',
            'password' => 'required|min:5|max:255'
        ]);

        User::create($validatedData);
        return redirect('/login')->with('success', 'Registration success, please login!');
    }
}
