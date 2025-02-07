<?php

namespace App\Http\Controllers;

use App\Exports\ContentsArchiveExport;
use App\Models\UserArchive;
use App\Models\UserContent;
use App\Models\UserProfile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class UserContentController extends Controller
{
    public function saveUserContent(Request $request)
    {
        $user = Auth::user();
        $userProfile = UserProfile::where('user_id', $user->id)->first();

        try {
            $request->validate([
                'file_path' => 'required|file|mimes:jpeg,png,jpg,mp4,mov|max:153600',
                'caption' => 'required|string|max:150',
            ]);
        } catch (ValidationException $e) {
            return redirect()->back()->withInput()->withErrors($e->errors());
        }

        $file = $request->file('file_path');
        $file_path = $file->store('uploads/user_content', 'public');

        DB::beginTransaction();
        try {
            $userContent = UserContent::create([
                'user_profile_id' => $userProfile->id,
                'caption' => $request->caption,
                'file_path' => $file_path,
            ]);

            $thumbnailPath = null;
            if ($request->has('thumbnail')) {
                $thumbnailData = $request->input('thumbnail');

                // Decode Base64
                $thumbnailPath = 'thumbnails/' . time() . '.jpg';

                Storage::disk('public')->put($thumbnailPath, base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $thumbnailData)));
            }

            UserArchive::create([
                'user_profile_id' => $userProfile->id,
                'thumbnail' => $thumbnailPath ?? $file_path,
                'content_id' => $userContent->id
            ]);


            DB::commit();
            return redirect()->intended('/');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('home');
    }

    public function validate(Request $request) {}

    public function exportXlsx(Request $request)
    {

        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $date = Carbon::now()->format('Y-m-d_H-i-s');
        $user = Auth::user();
        $userProfile = $user->userProfile;

        // FIlter berdasarkan tanggal
        $contentArchive = $userProfile->contentsArchive()
            ->with('content')
            ->whereHas('content', function ($query) use ($start_date, $end_date) {
                if ($start_date && $end_date) {
                    $query->whereBetween('created_at', [$start_date, $end_date]);
                }
            })
            ->get();

        // Format data yang akan diekspor
        $archive = $contentArchive->map(function ($item) {
            return [
                'Content Posted' => $item->content->file_path ?? 'N/A',
                'Caption' => $item->content->caption ?? 'N/A',
                'Created At' => $item->content->created_at ? $item->content->created_at->format('Y-m-d H:i:s') : 'N/A',
            ];
        });

        return Excel::download(new ContentsArchiveExport($archive), "contents-archive_{$date}.xlsx");
    }

    public function exportPdf(Request $request)
    {

        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $date = Carbon::now()->format('Y-m-d_H-i-s');
        $user = Auth::user();
        $userProfile = $user->userProfile;

        // FIlter berdasarkan tanggal
        $contentArchive = $userProfile->contentsArchive()
            ->with('content')
            ->whereHas('content', function ($query) use ($start_date, $end_date) {
                if ($start_date && $end_date) {
                    $query->whereBetween('created_at', [$start_date, $end_date]);
                }
            })
            ->get();

        // Format data yang akan diekspor
        $archive = [];
        foreach ($contentArchive as $item) {
            $archive[] = [
                'file_path' => $item->content->file_path,
                'caption' => $item->content->caption,
                'created_at' => $item->content->created_at->format('Y-m-d H:i:s'),
            ];
        }

        $pdf = Pdf::loadView('utils.contents-archive-pdf', compact('archive'));

        return $pdf->download("contents-archive_{$date}.pdf");
    }
}
