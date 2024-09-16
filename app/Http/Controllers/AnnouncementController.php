<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\AnnouncementAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AnnouncementController extends Controller
{

    public function index()
    {
        $announcements = Announcement::get();

        return view('announcements', [
            'announcements' => $announcements
        ]);

    }

    public function createAnnouncement()
    {
        return view('announcement-maker');
    }

    public function newAnnouncement(Request $request)
    {
        try {

            DB::beginTransaction();

            $validated = $request->validate([
                'title' => 'required|string',
                'content' => 'required|string',
            ]);

            $announcement = Announcement::create([
                'title' => $validated['title'],
                'content' => $validated['content'],
                'user_id' => 1,
            ]);

            AnnouncementAttachment::whereNull('announcement_id')
                ->where('session_id', session_id())
                ->update([
                    'announcement_id' => $announcement->id
                ]);

            DB::commit();

            return redirect()->route('announcements');

        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()->back()->withErrors([
                'message' => $e->getMessage()
            ]);

        }

    }
}
