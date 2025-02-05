<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

    public function profileEdit()
    {
        return view('pages.profile-edit');
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
