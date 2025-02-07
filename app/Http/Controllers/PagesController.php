<?php

namespace App\Http\Controllers;

use App\Models\UserPicture;
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

        $userProfile = $user->userProfile;
        $userPicture = $userProfile->profilePicture;
        $feedRow = $userProfile->setting->feed_row_count;

        return view('pages.edit-profile', compact('user', 'userProfile', 'userPicture', 'feedRow'));
    }

    public function createNewPost()
    {
        return view('pages.create-new-post');
    }

    public function viewArchive()
    {
        $user = Auth::user();
        $userProfile = $user->userProfile;
        $contentArchive = $userProfile->contentsArchive()->with('content')->get();

        return view('pages.view-archive', compact('contentArchive'));
    }
}
