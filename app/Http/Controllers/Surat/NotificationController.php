<?php

namespace App\Http\Controllers\Surat;

use App\Http\Controllers\Controller;
use App\Models\SuratNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $notifications = SuratNotification::query()
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate(20);

        return view('dashboard-surat.notifications.index', [
            'title' => 'Notifikasi Surat',
            'notifications' => $notifications,
        ]);
    }

    public function markRead(Request $request, SuratNotification $notification)
    {
        if ((int) $notification->user_id !== (int) $request->user()->id) {
            abort(403);
        }

        $notification->update([
            'read_at' => now(),
        ]);

        return back()->with('success', 'Notifikasi ditandai sudah dibaca.');
    }
}
