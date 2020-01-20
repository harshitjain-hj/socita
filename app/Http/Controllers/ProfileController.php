<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;


class ProfileController extends Controller
{
    public function index(User $user)
    {
        // if the logged in user is following
        $follows = (auth()->user()) ? auth()->user()->following->contains($user->id) : false;
        
        // dd($follows);
        return view('profile/index', compact('user', 'follows'));
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user->profile);

        return view('profile/edit', compact('user'));
    }

    public function update(User $user)
    {
        $this->authorize('update', $user->profile);

        $data = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'url' => 'url',
            'profile_image' => 'url',
        ]); 
        
        auth()->user()->profile->update($data);

        // dd($data);
        return redirect("/profile/{$user->id}");
    }
}
