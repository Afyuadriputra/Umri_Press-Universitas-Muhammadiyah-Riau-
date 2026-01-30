<?php

namespace App\Http\Controllers\Surat;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Disposition;
use App\Models\DispositionRecipient;
use App\Models\IncomingLetter;
use App\Models\SuratNotification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DispositionController extends Controller
{
    public function index()
    {
        $userId = request()->user()->id;

        $dispositions = Disposition::query()
            ->whereHas('recipients', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->with(['incomingLetter', 'recipients.user'])
            ->latest()
            ->paginate(15);

        return view('dashboard-surat.disposisi.index', [
            'title' => 'Disposisi Saya',
            'dispositions' => $dispositions,
        ]);
    }

    public function store(Request $request, IncomingLetter $incomingLetter)
    {
        $validated = $request->validate([
            'to_user_id' => ['required', 'exists:users,id'],
            'cc_user_ids' => ['nullable', 'array'],
            'cc_user_ids.*' => ['exists:users,id'],
            'instruction' => ['nullable', 'string'],
            'due_date' => ['nullable', 'date'],
            'note' => ['nullable', 'string'],
        ]);

        $disposition = Disposition::create([
            'incoming_letter_id' => $incomingLetter->id,
            'instruction' => $validated['instruction'] ?? null,
            'due_date' => $validated['due_date'] ?? null,
            'note' => $validated['note'] ?? null,
            'status' => 'baru',
            'created_by' => $request->user()->id,
        ]);

        DispositionRecipient::create([
            'disposition_id' => $disposition->id,
            'user_id' => $validated['to_user_id'],
            'role' => 'to',
        ]);

        $ccIds = collect($validated['cc_user_ids'] ?? [])
            ->unique()
            ->reject(fn ($id) => (int) $id === (int) $validated['to_user_id']);

        foreach ($ccIds as $ccId) {
            DispositionRecipient::create([
                'disposition_id' => $disposition->id,
                'user_id' => $ccId,
                'role' => 'cc',
            ]);
        }

        $recipientIds = collect([$validated['to_user_id']])
            ->merge($ccIds)
            ->unique();

        $this->notifyUsers($recipientIds->all(), [
            'title' => 'Disposisi baru',
            'body' => $incomingLetter->subject,
            'link' => route('dashboard-surat.incoming.show', $incomingLetter),
        ]);

        $this->logAction($request->user()->id, 'disposition.create', $disposition->id, [
            'incoming_letter_id' => $incomingLetter->id,
        ]);

        return back()->with('success', 'Disposisi berhasil ditambahkan.');
    }

    public function updateStatus(Request $request, Disposition $disposition)
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(['baru', 'diproses', 'selesai'])],
        ]);

        $disposition->update(['status' => $validated['status']]);

        if ($validated['status'] === 'selesai' && $disposition->created_by) {
            $this->notifyUsers([$disposition->created_by], [
                'title' => 'Disposisi selesai',
                'body' => $disposition->incomingLetter?->subject ?? 'Disposisi telah selesai diproses.',
                'link' => route('dashboard-surat.incoming.show', $disposition->incomingLetter),
            ]);
        }

        $this->logAction($request->user()->id, 'disposition.update_status', $disposition->id, [
            'status' => $validated['status'],
        ]);

        return back()->with('success', 'Status disposisi diperbarui.');
    }

    private function notifyUsers(array $userIds, array $payload): void
    {
        $uniqueIds = collect($userIds)->unique()->filter();

        foreach ($uniqueIds as $userId) {
            SuratNotification::create([
                'user_id' => $userId,
                'title' => $payload['title'],
                'body' => $payload['body'] ?? null,
                'link' => $payload['link'] ?? null,
            ]);
        }
    }

    private function logAction(int $userId, string $action, int $entityId, array $meta): void
    {
        AuditLog::create([
            'user_id' => $userId,
            'action' => $action,
            'entity_type' => Disposition::class,
            'entity_id' => $entityId,
            'meta' => $meta,
        ]);
    }
}
