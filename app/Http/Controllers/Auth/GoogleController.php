<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        $googleUser = Socialite::driver('google')->user();

        $user = User::updateOrCreate([
            'email' => $googleUser->getEmail(),
        ], [
            'name' => $googleUser->getName(),
            'avatar' => $googleUser->getAvatar(),
            'provider' => 'google',
            'provider_id' => $googleUser->getId(),
        ]);

        Auth::login($user);
        return redirect()->route('profile.edit')->with('success', 'Logged in with Google!');
    }
}
