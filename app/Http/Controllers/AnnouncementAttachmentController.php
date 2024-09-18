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

            $validated = $request->validate([
                'image' => 'required',
            ]);

            $file = $request->file('image')->store('public');

            if (!$file) {
                throw new \Exception('File upload failed');
            }

            return response()->json(['file' => Storage::url($file)]);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
