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
        $announcements = Announcement::paginate(10);

        return view('announcements', [
            'announcements' => $announcements
        ]);

    }


    public function createAnnouncement()
    {
        return view('announcement-maker');
    }

    public function viewAnnouncement($announcementID)
    {

        $announcement = Announcement::findOrFail($announcementID);

        return view('announcement-edit', [
            'announcement' => $announcement
        ]);
    }

    public function updateAnnouncement(Request $request, $announcementID)
    {

        try {
            DB::beginTransaction();
            $validated = $request->validate([
                'title' => 'required',
                'content' => 'required'
            ]);

            Announcement::findOrFail($announcementID)
                ->update($validated);

            DB::commit();

            return redirect()->back()->with(['message' => 'Update Success']);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['message' => $e->getMessage()]);
        }
    }

    public function deleteAnnouncement($announcementID)
    {
        try {
            DB::beginTransaction();
            Announcement::findOrFail($announcementID)->delete();
            DB::commit();
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['message' => $e->getMessage()]);
        }
    }


    public function newAnnouncement(Request $request)
    {
        try {

            DB::beginTransaction();

            $validated = $request->validate([
                'title' => 'required|string',
                'content' => 'required|string',
            ]);

            Announcement::create([
                'title' => $validated['title'],
                'content' => $validated['content'],
                'user_id' => 1,
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
