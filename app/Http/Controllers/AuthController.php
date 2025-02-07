<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserPicture;
use App\Models\UserProfile;
use App\Models\UserSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function signUp(Request $request)
    {
        try {
            $request->validate([
                'nama' => 'required|string|max:255',
                'username' => 'required|string|max:15|unique:users,username',
                'email' => 'required|string|email|max:255|unique:users,email',
                'password' => 'required|string|min:8|same:confirm_password',
                'confirm_password' => 'required|string|min:8|same:password',
            ]);
        } catch (ValidationException $e) {
            return redirect()->back()->withInput()->withErrors($e->errors());
        }
        DB::beginTransaction();

        try {

            $user = User::create([
                'name' => $request->nama,
                'email' => $request->email,
                'username' => $request->username,
                'password' => Hash::make($request->password),
            ]);
            $userProfile = UserProfile::create([
                'name' => $request->nama,
                'bio' => "Hello World",
                'user_id' => $user->id,
            ]);

            UserSetting::create([
                'user_profile_id' => $userProfile->id,
                'feed_row_count' => 3
            ]);

            UserPicture::create([
                'user_profile_id' => $userProfile->id,
            ]);


            DB::commit();
            return redirect()->route('auth.sign-in')->with('success', 'Berhasil mendaftar');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
    public function signIn(Request $request)
    {
        try {
            if (Auth::attempt($request->only('username', 'password'))) {
                $request->session()->regenerate();

                return redirect()->intended('/')->with('success', 'Login Berhasil');
            }

            return back()->with('error', 'Username atau Password Salah')->withInput();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return back();
        }
    }
    public function signOut(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('auth.sign-in')->with('success', 'You have been signed out successfully');
    }
}
