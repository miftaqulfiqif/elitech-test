<?php

namespace App\Http\Controllers;

use App\Models\UserContent;
use App\Models\UserPicture;
use App\Models\UserProfile;
use App\Models\UserSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $userProfile = $user->userProfile;
        $userPicture = $userProfile->profilePicture->file_path;
        $userContent = $userProfile->contents;
        $feedRowCount = $userProfile->setting->feed_row_count;

        return view('pages.home', compact('user', 'userProfile', 'userPicture', 'userContent', 'feedRowCount'));
    }
}
