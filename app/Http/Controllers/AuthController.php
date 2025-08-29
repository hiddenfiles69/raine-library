<?php

namespace App\Http\Controllers;

use App\Models\User; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register() {
        return view('auth.register');
    }

     public function login() {
        return view('auth.login');
    }

    public function registerUser(Request $request) {
       $incomingFields = $request->validate([
           'fullname' => 'required|string|max:255',
           'contactnum' => 'required|string|max:15',
           'email' => 'required|string|email|max:255|unique:users',
           'name' => 'required|string|max:255|unique:users',
           'password' => 'required|string|min:8',
           
       ]);
       $incomingFields['password'] = bcrypt($incomingFields['password']);
       $user = User::create($incomingFields);
        auth()->login($user);
        return redirect()->route('dashboard')->with("success", "Registration successful.");
    }

    public function loginUser(Request $request) { 
            $incomingFields = $request->validate([
                'loginemail' => ['required', 'email'],
                'loginpassword' => ['required'],
            ]);

            
            $credentials = [
                'email' => $incomingFields['loginemail'],
                'password' => $incomingFields['loginpassword'],
            ];

            
            if (Auth::attempt($credentials)) {
                
                $request->session()->regenerate();

                return redirect()->intended('dashboard');
            }

            
            return back()->withErrors([
                'loginpassword' => 'The provided password does not match our records.',
            ])->onlyInput('loginemail');
        }

        // Logout user
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}