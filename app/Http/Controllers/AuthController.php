<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

class AuthController extends Controller
{
    public function showRegister(){
        return view('auth.register');
    }

    public function register(Request $request){
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        // Redirect to a success page or login page
        return redirect()->route('register')->with('success', 'Registration successful!');
    }

    public function showLogin(){
        return view('auth.login');
    }

    public function login(Request $request){
        // Validate incoming data
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt login
        if (Auth::attempt($credentials)) {
            // Regenerate session
            $request->session()->regenerate();

            return redirect()->intended('dashboard');
    }

    // Error message
    return redirect()->back()->withErrors([
        'email' => 'Email or Password Incorrect',
    ])->onlyInput('email');
    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
