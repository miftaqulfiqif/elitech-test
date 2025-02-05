<?php

namespace App\Http\Controllers;

use App\Models\UserProfile;
use App\Models\UserSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller
{
    public function signIn()
    {
        return view('pages.auth.sign-in');
    }
    public function signUp()
    {
        return view('pages.auth.sign-up');
    }

    public function editProfile()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('auth.sign-in');
        }
        $userProfile = UserProfile::where('user_id', $user->id)->first();
        $feedRow = UserSetting::where('user_profile_id', $userProfile->id)->first();


        return view('pages.edit-profile', compact('user', 'userProfile', 'feedRow'));
    }

    public function profileSetting()
    {
        return view('pages.profile-setting');
    }
    public function viewArchive()
    {
        return view('pages.view-archive');
    }
}
