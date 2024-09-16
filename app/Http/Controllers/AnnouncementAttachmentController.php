<?php

namespace App\Http\Controllers;

use App\Models\AnnouncementAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AnnouncementAttachmentController extends Controller
{

    public function addImage(Request $request)
    {
        try {

            DB::beginTransaction();

            $validated = $request->validate([
                'image' => 'required',
                'announcement_id' => 'nullable',
            ]);

            $file = $request->file('image')->store('public');

            if (!$file) {
                throw new \Exception('File upload failed');
            }

            AnnouncementAttachment::create([
                'announcement_id' => $validated['announcement_id'] ?? null,
                'file' => $file,
                'session_id' => session_id(),
            ]);

            DB::commit();

            return response()->json(['file' => Storage::url($file)]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
