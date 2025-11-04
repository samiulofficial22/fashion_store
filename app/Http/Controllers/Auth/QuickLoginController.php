<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class QuickLoginController extends Controller
{
    public function showForm()
    {
        return view('frontend.auth.quick-login');
    }

    public function submit(Request $request)
    {
        $request->validate([
            'login' => 'required',
        ]);

        $input = $request->login;
        $isEmail = filter_var($input, FILTER_VALIDATE_EMAIL);

        // Check user by email or phone
        $user = User::where($isEmail ? 'email' : 'phone', $input)->first();

        if ($user) {
            Auth::login($user);
            return response()->json(['success' => true, 'message' => 'Welcome back!']);
        }

        // Create new user
        $user = User::create([
            'email' => $isEmail ? $input : null,
            'phone' => !$isEmail ? $input : null,
            'password' => Hash::make('123456'),
        ]);

        Auth::login($user);
        return response()->json(['success' => true, 'message' => 'Account created successfully!']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/')->with('success', 'Logged out successfully!');
    }
}
