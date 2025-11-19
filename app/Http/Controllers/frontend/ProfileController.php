<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('front-end.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // ✅ Validation
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => ['nullable','email','max:255', Rule::unique('users')->ignore($user->id)],
            'phone'   => ['nullable','string','max:20', Rule::unique('users')->ignore($user->id)],
            'address' => 'nullable|string|max:1000',
            'avatar'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // ✅ Handle avatar upload
        if ($request->hasFile('avatar')) {
            if ($user->avatar && Storage::exists(str_replace('storage/', 'public/', $user->avatar))) {
                Storage::delete(str_replace('storage/', 'public/', $user->avatar));
            }

            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = 'storage/' . $path;
        }

        // ✅ Update fields
        $user->name    = $request->name;
        $user->email   = $request->email;
        $user->phone   = $request->phone;
        $user->address = $request->address;
        $user->save();

        return back()->with('success', '✅ Profile updated successfully!');
    }
    
    public function destroy()
    {
        $user = Auth::user();
        Auth::logout();

        $user->delete();

        return redirect('/')->with('success', 'Your account has been deleted successfully.');
    }
}
