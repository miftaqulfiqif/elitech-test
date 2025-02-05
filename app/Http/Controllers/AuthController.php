<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function signUp(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|same:confirm-password',
            'confirm-password' => 'required|string|min:8|same:password',
        ]);

        DB::beginTransaction();

        try {
            if ($request->input('password') != $request->input('confirm-password')) {
                return back()->with('error', 'Password Tidak Sama')->withInput();
            }

            $user = User::create([
                'name' => $request->nama,
                'username' => $request->username,
                'password' => Hash::make($request->password),
            ]);

            // DataUser::create([
            //     'nama' => $request->nama,
            //     'alamat' => $request->alamat,
            //     'no_telp' => $request->no_telp,
            //     'no_sim' => $request->no_sim,
            //     'user_id' => $user->id
            // ]);

            DB::commit();
            return redirect()->route('login')->with('success', 'Berhasil mendaftar');
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
        return view('pages.auth.sign-in');
    }
}
