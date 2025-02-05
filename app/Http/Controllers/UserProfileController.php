<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserProfileController extends Controller
{
    public function saveUserProfile(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:15',
            'bio' => 'required|string|max:150',
            'feed_row' => 'required|numeric',
            'file_path' => 'required|file|mimes:jpeg,png,jpg|max:2048',
        ]);

        DB::beginTransaction();

        try {
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}
