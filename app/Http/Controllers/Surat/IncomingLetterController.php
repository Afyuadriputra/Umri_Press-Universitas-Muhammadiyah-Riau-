<?php

namespace App\Http\Controllers\Surat;

use App\Http\Controllers\Controller;
use App\Models\IncomingLetter;
use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class IncomingLetterController extends Controller
{
    private const STATUS_OPTIONS = ['baru', 'diproses', 'selesai', 'arsip'];

    public function index(Request $request)
    {
        $letters = $this->buildQuery($request)
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('dashboard-surat.incoming.index', [
            'title' => 'Surat Masuk',
            'letters' => $letters,
            'statusOptions' => self::STATUS_OPTIONS,
            'isArchive' => false,
        ]);
    }

    public function archive(Request $request)
    {
        $letters = $this->buildQuery($request)
            ->where('status', 'arsip')
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('dashboard-surat.incoming.index', [
            'title' => 'Arsip Surat Masuk',
            'letters' => $letters,
            'statusOptions' => self::STATUS_OPTIONS,
            'isArchive' => true,
        ]);
    }

    public function archiveStore(Request $request, IncomingLetter $incomingLetter)
    {
        $incomingLetter->status = 'arsip';
        $incomingLetter->save();

        $this->logAction($request->user()->id, 'incoming.archive', $incomingLetter->id, []);

        return redirect()
            ->back()
            ->with('success', 'Surat masuk berhasil diarsipkan.');
    }

    public function create()
    {
        return view('dashboard-surat.incoming.create', [
            'title' => 'Input Surat Masuk',
            'statusOptions' => self::STATUS_OPTIONS,
            'staff' => User::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateRequest($request);

        $scanPath = $request->file('scan_file')
            ? $request->file('scan_file')->store('surat/masuk/scan', 'public')
            : null;

        $attachmentPath = $request->file('attachment_file')
            ? $request->file('attachment_file')->store('surat/masuk/lampiran', 'public')
            : null;

        $agendaYear = $this->resolveAgendaYear($validated['received_at']);
        $agendaNumber = $this->generateAgendaNumber($agendaYear);

        $letter = IncomingLetter::create([
            'received_at' => $validated['received_at'],
            'letter_date' => $validated['letter_date'] ?? null,
            'letter_number' => $validated['letter_number'] ?? null,
            'agenda_number' => $agendaNumber,
            'agenda_year' => $agendaYear,
            'sender' => $validated['sender'],
            'subject' => $validated['subject'],
            'summary' => $validated['summary'] ?? null,
            'status' => $validated['status'],
            'internal_notes' => $validated['internal_notes'] ?? null,
            'assigned_user_id' => $validated['assigned_user_id'] ?? null,
            'disposition_note' => $validated['disposition_note'] ?? null,
            'scan_path' => $scanPath,
            'attachment_path' => $attachmentPath,
            'created_by' => $request->user()->id,
        ]);

        $this->logAction($request->user()->id, 'incoming.create', $letter->id, [
            'agenda_number' => $agendaNumber,
        ]);

        return redirect()
            ->route('dashboard-surat.incoming.show', $letter)
            ->with('success', 'Surat masuk berhasil disimpan.');
    }

    public function show(IncomingLetter $incomingLetter)
    {
        return view('dashboard-surat.incoming.show', [
            'title' => 'Detail Surat Masuk',
            'letter' => $incomingLetter->load(['assignedUser', 'creator', 'dispositions.recipients.user']),
            'staff' => User::orderBy('name')->get(),
        ]);
    }

    public function edit(IncomingLetter $incomingLetter)
    {
        return view('dashboard-surat.incoming.edit', [
            'title' => 'Edit Surat Masuk',
            'letter' => $incomingLetter,
            'statusOptions' => self::STATUS_OPTIONS,
            'staff' => User::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, IncomingLetter $incomingLetter)
    {
        $validated = $this->validateRequest($request, $incomingLetter->id);

        if ($request->file('scan_file')) {
            $this->deleteFile($incomingLetter->scan_path);
            $incomingLetter->scan_path = $request->file('scan_file')->store('surat/masuk/scan', 'public');
        }

        if ($request->file('attachment_file')) {
            $this->deleteFile($incomingLetter->attachment_path);
            $incomingLetter->attachment_path = $request->file('attachment_file')->store('surat/masuk/lampiran', 'public');
        }

        $incomingLetter->fill([
            'received_at' => $validated['received_at'],
            'letter_date' => $validated['letter_date'] ?? null,
            'letter_number' => $validated['letter_number'] ?? null,
            'sender' => $validated['sender'],
            'subject' => $validated['subject'],
            'summary' => $validated['summary'] ?? null,
            'status' => $validated['status'],
            'internal_notes' => $validated['internal_notes'] ?? null,
            'assigned_user_id' => $validated['assigned_user_id'] ?? null,
            'disposition_note' => $validated['disposition_note'] ?? null,
        ]);
        $incomingLetter->save();

        $this->logAction($request->user()->id, 'incoming.update', $incomingLetter->id, []);

        return redirect()
            ->route('dashboard-surat.incoming.show', $incomingLetter)
            ->with('success', 'Surat masuk berhasil diperbarui.');
    }

    public function destroy(IncomingLetter $incomingLetter)
    {
        $this->deleteFile($incomingLetter->scan_path);
        $this->deleteFile($incomingLetter->attachment_path);
        $incomingLetter->delete();

        $this->logAction(request()->user()->id, 'incoming.delete', $incomingLetter->id, []);

        return redirect()
            ->route('dashboard-surat.incoming.index')
            ->with('success', 'Surat masuk berhasil dihapus.');
    }

    public function exportCsv(Request $request)
    {
        $letters = $this->buildQuery($request)->latest()->get();

        $filename = 'surat_masuk_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        $callback = function () use ($letters) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Agenda', 'Tanggal Terima', 'Nomor Surat', 'Pengirim', 'Perihal', 'Status']);
            foreach ($letters as $letter) {
                fputcsv($handle, [
                    $letter->agenda_number,
                    optional($letter->received_at)->format('Y-m-d'),
                    $letter->letter_number,
                    $letter->sender,
                    $letter->subject,
                    $letter->status,
                ]);
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPdf(Request $request)
    {
        $letters = $this->buildQuery($request)->latest()->get();

        return view('dashboard-surat.incoming.export-pdf', [
            'title' => 'Buku Agenda Surat Masuk',
            'letters' => $letters,
            'generatedAt' => now(),
        ]);
    }

    private function buildQuery(Request $request)
    {
        return IncomingLetter::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search')->toString();
                $query->where(function ($sub) use ($search) {
                    $sub->where('letter_number', 'like', "%{$search}%")
                        ->orWhere('subject', 'like', "%{$search}%")
                        ->orWhere('sender', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('sender'), fn ($query) => $query->where('sender', 'like', '%' . $request->string('sender')->toString() . '%'))
            ->when($request->filled('subject'), fn ($query) => $query->where('subject', 'like', '%' . $request->string('subject')->toString() . '%'))
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')->toString()))
            ->when($request->filled('date_from'), fn ($query) => $query->whereDate('received_at', '>=', $request->date('date_from')))
            ->when($request->filled('date_to'), fn ($query) => $query->whereDate('received_at', '<=', $request->date('date_to')));
    }

    private function validateRequest(Request $request, ?int $id = null): array
    {
        return $request->validate([
            'received_at' => ['required', 'date'],
            'letter_date' => ['nullable', 'date'],
            'letter_number' => ['nullable', 'string', 'max:100'],
            'sender' => ['required', 'string', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'summary' => ['nullable', 'string'],
            'status' => ['required', Rule::in(self::STATUS_OPTIONS)],
            'internal_notes' => ['nullable', 'string'],
            'assigned_user_id' => ['nullable', 'exists:users,id'],
            'disposition_note' => ['nullable', 'string'],
            'scan_file' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:10240'],
            'attachment_file' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:10240'],
        ]);
    }

    private function deleteFile(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    private function resolveAgendaYear(string $receivedAt): int
    {
        return (int) date('Y', strtotime($receivedAt));
    }

    private function generateAgendaNumber(int $year): string
    {
        $latest = IncomingLetter::where('agenda_year', $year)
            ->orderByDesc('agenda_number')
            ->value('agenda_number');

        $next = 1;
        if ($latest && preg_match('/^(\\d+)$/', $latest, $matches)) {
            $next = (int) $matches[1] + 1;
        }

        return str_pad((string) $next, 4, '0', STR_PAD_LEFT);
    }

    private function logAction(int $userId, string $action, int $entityId, array $meta): void
    {
        AuditLog::create([
            'user_id' => $userId,
            'action' => $action,
            'entity_type' => IncomingLetter::class,
            'entity_id' => $entityId,
            'meta' => $meta,
        ]);
    }
}
