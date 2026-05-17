<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display the logged-in user's profile.
     */
    public function show()
    {
        $user = Auth::user();
        return view('pages.profile', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'gender' => 'nullable|string|in:male,female,preferNotToSay',
        ]);

        $user->update([
            'name'   => $request->name,
            'email'  => $request->email,
            'gender' => $request->gender,
        ]);

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully!');
    }

    /**
     * Update the user's profile picture.
     */
    public function updatePicture(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $user = Auth::user();

        // Delete old picture if it exists and isn't the default
        if ($user->profile_picture_path && file_exists(public_path('uploads/' . $user->profile_picture_path))) {
            if ($user->profile_picture_path !== 'default.webp') {
                unlink(public_path('uploads/' . $user->profile_picture_path));
            }
        }

        // Store new picture in public/uploads
        $file = $request->file('profile_picture');
        $filename = 'profile_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads'), $filename);

        $user->update([
            'profile_picture_path' => $filename,
        ]);

        return redirect()->route('profile.show')->with('success', 'Profile picture updated!');
    }
}
