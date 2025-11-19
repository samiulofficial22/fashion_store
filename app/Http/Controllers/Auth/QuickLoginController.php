<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class QuickLoginController extends Controller
{
    /**
     * Show quick login modal or page
     */
    public function showLoginForm()
    {
        return view('front-end.profile.quick-login'); // ✅ path ঠিক করা হয়েছে
    }

    /**
     * Handle quick login or register
     */
    public function submit(Request $request)
    {
        $request->validate([
            'login' => 'required',
        ]);

        $input = $request->login;
        $isEmail = filter_var($input, FILTER_VALIDATE_EMAIL);

        // Check user by email or phone
        $user = User::where($isEmail ? 'email' : 'phone', $input)->first();

        // ✅ যদি ইউজার থাকে তাহলে সরাসরি লগইন
        if ($user) {
            Auth::login($user);

            return response()->json([
                'success'  => true,
                'redirect' => route('dashboard'), // ✅ Redirect to dashboard
                'message'  => 'Welcome back, ' . ($user->name ?? 'User') . '!',
            ]);
        }

        // ✅ না থাকলে নতুন ইউজার তৈরি করা হবে
        $user = User::create([
            'email'    => $isEmail ? $input : null,
            'phone'    => !$isEmail ? $input : null,
            'password' => Hash::make('123456'), // default password
        ]);

        Auth::login($user);

        return response()->json([
            'success'  => true,
            'redirect' => route('dashboard'), // ✅ সফল হলে dashboard এ redirect
            'message'  => 'Account created successfully! Welcome, ' . ($user->name ?? 'User') . '!',
        ]);
    }

    /**
     * Logout
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('home')->with('success', 'Logged out successfully!');
    }
}
