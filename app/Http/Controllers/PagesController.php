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
}
