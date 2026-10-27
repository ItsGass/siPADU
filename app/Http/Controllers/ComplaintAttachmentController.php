<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\ComplaintAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ComplaintAttachmentController extends Controller
{
    /**
     * Tampilkan atau unduh lampiran pengaduan.
     */
    public function __invoke(Request $request, Complaint $complaint, ComplaintAttachment $attachment): StreamedResponse
    {
        abort_unless($attachment->complaint_id === $complaint->id, 404);

        $user = $request->user();

        abort_unless(
            $user !== null && ($user->isAdmin() || $complaint->isOwnedBy($user)),
            403,
        );

        abort_unless(Storage::disk('local')->exists($attachment->path), 404);

        $disk = Storage::disk('local');

        if ($request->boolean('download')) {
            return $disk->download($attachment->path, $attachment->original_name);
        }

        return $disk->response($attachment->path, $attachment->original_name, [
            'Content-Type' => $attachment->mime_type,
        ]);
    }
}
