<?php

namespace App\Http\Controllers;

use App\Models\UserPicture;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('auth.sign-in');
        }

        $userProfile = UserProfile::where('user_id', $user->id)->first();
        $userPicture = UserPicture::where('user_profile_id', $userProfile->id)->first();

        return view('welcome', compact('user', 'userProfile', 'userPicture'));
    }
}
