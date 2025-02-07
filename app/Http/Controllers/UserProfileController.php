<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserPicture;
use App\Models\UserProfile;
use App\Models\UserSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class UserProfileController extends Controller
{
    public function saveUserProfile(Request $request)
    {
        $userLogin = Auth::user();
        $user = User::where('id', $userLogin->id)->first();

        $userProfile = UserProfile::where('user_id', $userLogin->id)->first();
        $userPicture = UserPicture::where('user_profile_id', $userProfile->id)->first();
        $userSetting = UserSetting::where('user_profile_id', $userProfile->id)->first();

        try {
            $request->validate([
                'username' => 'required|string|max:15',
                'bio' => 'required|string|max:150',
                'feed_row_count' => 'required|numeric',
                'file_path' => $userProfile ? 'nullable|file|mimes:jpeg,png,jpg|max:2048' : 'required|file|mimes:jpeg,png,jpg|max:2048',
                'old_file_path' => 'nullable|string',
            ]);
        } catch (ValidationException $e) {
            return redirect()->back()->withInput()->withErrors($e->errors());
        }

        $file = $request->file('file_path');
        if ($request->hasFile('file_path') && $request->file('file_path')->isValid()) {
            // Jika file baru diunggah dan valid, simpan file baru
            $file_path = $file->store('uploads/profile_picture', 'public');

            // Hapus foto lama jika ada
            if ($userPicture && $userPicture->file_path && Storage::exists('public/' . $userPicture->file_path)) {
                Storage::delete('public/' . $userPicture->file_path);
            }
        } else {
            // Jika tidak ada file baru, gunakan foto lama
            $file_path = $request->old_file_path ?? ($userPicture ? $userPicture->file_path : null);
        }

        DB::beginTransaction();
        try {
            $userPicture->update(['file_path' => $file_path]);
            $user->update([
                'username' => $request->username,
            ]);
            $userProfile->update([
                'bio' => $request->bio,
            ]);
            $userSetting->update([
                'feed_row_count' => $request->feed_row_count
            ]);

            DB::commit();
            return redirect()->intended('/')->with('success', 'data berhasil di update');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}
