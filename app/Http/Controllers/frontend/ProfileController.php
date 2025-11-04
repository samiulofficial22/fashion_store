<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('frontend.profile.edit');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = 'storage/' . $path;
        }

        $user->update($request->only('name', 'phone', 'address'));
        $user->save();

        return back()->with('success', 'Profile updated successfully!');
    }
}
