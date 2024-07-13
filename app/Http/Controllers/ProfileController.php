<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Seat;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $totalMoviesWatched = Seat::where('email', $user->email)->where('status', 'occupied')->count();
        return view('profile.index', compact('user', 'totalMoviesWatched'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profile.update', compact('user'));
    }

    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();
        $avatar = $request->file('avatar');
        $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
        $avatarPath = $avatar->storeAs('users-avatar', $avatarName, 'public');

        // Delete old avatar if it exists and is not the default avatar
        if ($user->avatar && $user->avatar !== 'avatar.png') {
            Storage::disk('public')->delete('users-avatar/' . $user->avatar);
        }

        $user->avatar = $avatarName;
        $user->save();

        return back()->with('success', 'Profile picture updated successfully.');
    }

    public function deleteAvatar()
    {
        $user = Auth::user();

        if ($user->avatar && $user->avatar !== 'avatar.png') {
            Storage::disk('public')->delete('users-avatar/' . $user->avatar);
            $user->avatar = 'avatar.png';
            $user->save();
        }

        return back()->with('success', 'Profile picture reset to default successfully.');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|confirmed|min:6',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        $user->password = bcrypt($request->new_password);
        $user->save();

        return back()->with('success', 'Password changed successfully.');
    }
}
