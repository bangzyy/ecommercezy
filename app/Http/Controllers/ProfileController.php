<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $reviews = $user->reviews()->with('product')->latest()->get();

        return view('profile', compact('user', 'reviews'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'confirm_password' => 'required_with:password|same:password',
            'avatar' => 'image',
        ]);
        $input = $request->all();
        if ($request->hasFile('avatar')) {
            $avatarName = time() . '.' . $request->avatar->getClientOriginalExtension();
            $request->avatar->move(public_path('avatars'), $avatarName);
            $input['avatar'] = $avatarName;
        } else {
            unset($input['avatar']);
        }
        if ($request->filled('password')) {
            $input['password'] = Hash::make($input['password']);
        } else {
            unset($input['password']);
        }
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->update($input);
        return back()->with('success', 'Profile Updated Successfully');
    }
}
