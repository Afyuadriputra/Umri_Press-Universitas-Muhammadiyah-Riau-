<?php

namespace App\Http\Controllers\Surat;

use App\Http\Controllers\Controller;
use App\Models\LetterTemplate;
use App\Models\LetterType;
use App\Models\LetterUnit;
use App\Models\OutgoingLetter;
use App\Models\AuditLog;
use App\Models\SuratSetting;
use App\Models\SuratNotification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class OutgoingLetterController extends Controller
{
    private const STATUS_OPTIONS = ['draft', 'approved', 'sent', 'archived'];

    public function index(Request $request)
    {
        $letters = $this->buildQuery($request)
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('dashboard-surat.outgoing.index', [
            'title' => 'Surat Keluar',
            'letters' => $letters,
            'statusOptions' => self::STATUS_OPTIONS,
            'units' => LetterUnit::orderBy('name')->get(),
            'types' => LetterType::orderBy('name')->get(),
            'isArchive' => false,
        ]);
    }

    public function archive(Request $request)
    {
        $letters = $this->buildQuery($request)
            ->where('status', 'archived')
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('dashboard-surat.outgoing.index', [
            'title' => 'Arsip Surat Keluar',
            'letters' => $letters,
            'statusOptions' => self::STATUS_OPTIONS,
            'units' => LetterUnit::orderBy('name')->get(),
            'types' => LetterType::orderBy('name')->get(),
            'isArchive' => true,
        ]);
    }

    public function archiveStore(Request $request, OutgoingLetter $outgoingLetter)
    {
        $outgoingLetter->status = 'archived';
        $outgoingLetter->save();

        $this->logAction($request->user()->id, 'outgoing.archive', $outgoingLetter->id, []);

        return redirect()
            ->back()
            ->with('success', 'Surat keluar berhasil diarsipkan.');
    }

    public function create()
    {
        return view('dashboard-surat.outgoing.create', [
            'title' => 'Draft Surat Keluar',
            'statusOptions' => self::STATUS_OPTIONS,
            'approvers' => User::orderBy('name')->get(),
            'units' => LetterUnit::where('is_active', true)->orderBy('name')->get(),
            'types' => LetterType::where('is_active', true)->orderBy('name')->get(),
            'templates' => LetterTemplate::where('is_active', true)->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateRequest($request);

        $attachmentPath = $request->file('attachment_file')
            ? $request->file('attachment_file')->store('surat/keluar/lampiran', 'public')
            : null;

        $finalPath = $request->file('final_file')
            ? $request->file('final_file')->store('surat/keluar/final', 'public')
            : null;
        $signaturePath = $request->file('signature_file')
            ? $request->file('signature_file')->store('surat/keluar/signature', 'public')
            : null;

        $letterNumber = $validated['letter_number'] ?? null;
        if (! $letterNumber && $this->shouldGenerateNumber($validated['status'])) {
            $year = $this->resolveYear($validated['sent_at'] ?? null);
            $month = $this->resolveMonth($validated['sent_at'] ?? null);
            $letterNumber = $this->generateLetterNumber(
                $year,
                $month,
                $validated['letter_type'] ?? null,
                $validated['unit_code'] ?? null
            );
        }

        $verificationCode = $this->generateVerificationCode();
        $body = $validated['body'] ?? null;
        if (! $body && $request->filled('template_id')) {
            $template = LetterTemplate::find($request->integer('template_id'));
            $body = $template ? $this->renderTemplate($template->content, $validated) : null;
        }

        $letter = OutgoingLetter::create([
            'letter_number' => $letterNumber,
            'recipient' => $validated['recipient'],
            'recipient_phone' => $validated['recipient_phone'] ?? null,
            'recipient_position' => $validated['recipient_position'] ?? null,
            'subject' => $validated['subject'],
            'body' => $body,
            'letter_type' => $validated['letter_type'] ?? null,
            'unit_code' => $validated['unit_code'] ?? null,
            'status' => $validated['status'],
            'sent_at' => $validated['sent_at'] ?? null,
            'final_file_path' => $finalPath,
            'signature_path' => $signaturePath,
            'signed_at' => $signaturePath ? now() : null,
            'verification_code' => $verificationCode,
            'attachment_path' => $attachmentPath,
            'created_by' => $request->user()->id,
            'approved_by' => $validated['approved_by'] ?? null,
            'template_id' => $validated['template_id'] ?? null,
        ]);

        $this->logAction($request->user()->id, 'outgoing.create', $letter->id, []);
        $this->notifyApproverIfNeeded($letter, null, null);

        return redirect()
            ->route('dashboard-surat.outgoing.show', $letter)
            ->with('success', 'Surat keluar berhasil disimpan.');
    }

    public function show(OutgoingLetter $outgoingLetter)
    {
        return view('dashboard-surat.outgoing.show', [
            'title' => 'Detail Surat Keluar',
            'letter' => $outgoingLetter->load(['creator', 'approver']),
        ]);
    }

    public function edit(OutgoingLetter $outgoingLetter)
    {
        return view('dashboard-surat.outgoing.edit', [
            'title' => 'Edit Surat Keluar',
            'letter' => $outgoingLetter,
            'statusOptions' => self::STATUS_OPTIONS,
            'approvers' => User::orderBy('name')->get(),
            'units' => LetterUnit::where('is_active', true)->orderBy('name')->get(),
            'types' => LetterType::where('is_active', true)->orderBy('name')->get(),
            'templates' => LetterTemplate::where('is_active', true)->orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, OutgoingLetter $outgoingLetter)
    {
        $previousApprover = $outgoingLetter->approved_by;
        $previousStatus = $outgoingLetter->status;
        $validated = $this->validateRequest($request, $outgoingLetter->id);

        if ($request->file('attachment_file')) {
            $this->deleteFile($outgoingLetter->attachment_path);
            $outgoingLetter->attachment_path = $request->file('attachment_file')->store('surat/keluar/lampiran', 'public');
        }

        if ($request->file('final_file')) {
            $this->deleteFile($outgoingLetter->final_file_path);
            $outgoingLetter->final_file_path = $request->file('final_file')->store('surat/keluar/final', 'public');
        }

        if ($request->file('signature_file')) {
            $this->deleteFile($outgoingLetter->signature_path);
            $outgoingLetter->signature_path = $request->file('signature_file')->store('surat/keluar/signature', 'public');
            $outgoingLetter->signed_at = now();
        }

        $letterNumber = $validated['letter_number'] ?? $outgoingLetter->letter_number;
        if (! $letterNumber && $this->shouldGenerateNumber($validated['status'])) {
            $year = $this->resolveYear($validated['sent_at'] ?? null);
            $month = $this->resolveMonth($validated['sent_at'] ?? null);
            $letterNumber = $this->generateLetterNumber(
                $year,
                $month,
                $validated['letter_type'] ?? null,
                $validated['unit_code'] ?? null
            );
        }

        $outgoingLetter->fill([
            'letter_number' => $letterNumber,
            'recipient' => $validated['recipient'],
            'recipient_phone' => $validated['recipient_phone'] ?? null,
            'recipient_position' => $validated['recipient_position'] ?? null,
            'subject' => $validated['subject'],
            'body' => $validated['body'] ?? null,
            'letter_type' => $validated['letter_type'] ?? null,
            'unit_code' => $validated['unit_code'] ?? null,
            'status' => $validated['status'],
            'sent_at' => $validated['sent_at'] ?? null,
            'approved_by' => $validated['approved_by'] ?? null,
            'template_id' => $validated['template_id'] ?? null,
        ]);

        if (! $outgoingLetter->verification_code) {
            $outgoingLetter->verification_code = $this->generateVerificationCode();
        }
        $outgoingLetter->save();

        $this->logAction($request->user()->id, 'outgoing.update', $outgoingLetter->id, []);
        $this->notifyApproverIfNeeded($outgoingLetter, $previousApprover, $previousStatus);

        return redirect()
            ->route('dashboard-surat.outgoing.show', $outgoingLetter)
            ->with('success', 'Surat keluar berhasil diperbarui.');
    }

    public function destroy(OutgoingLetter $outgoingLetter)
    {
        $this->deleteFile($outgoingLetter->attachment_path);
        $this->deleteFile($outgoingLetter->final_file_path);
        $this->deleteFile($outgoingLetter->signature_path);
        $outgoingLetter->delete();

        $this->logAction(request()->user()->id, 'outgoing.delete', $outgoingLetter->id, []);

        return redirect()
            ->route('dashboard-surat.outgoing.index')
            ->with('success', 'Surat keluar berhasil dihapus.');
    }

    public function exportCsv(Request $request)
    {
        $letters = $this->buildQuery($request)->latest()->get();

        $filename = 'surat_keluar_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        $callback = function () use ($letters) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Tanggal', 'Nomor Surat', 'Penerima', 'Perihal', 'Jenis', 'Unit', 'Status']);
            foreach ($letters as $letter) {
                fputcsv($handle, [
                    optional($letter->sent_at)->format('Y-m-d'),
                    $letter->letter_number,
                    $letter->recipient,
                    $letter->subject,
                    $letter->letter_type,
                    $letter->unit_code,
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

        return view('dashboard-surat.outgoing.export-pdf', [
            'title' => 'Buku Agenda Surat Keluar',
            'letters' => $letters,
            'generatedAt' => now(),
        ]);
    }

    private function validateRequest(Request $request, ?int $id = null): array
    {
        return $request->validate([
            'letter_number' => ['nullable', 'string', 'max:100'],
            'recipient' => ['required', 'string', 'max:255'],
            'recipient_phone' => ['nullable', 'string', 'max:30'],
            'recipient_position' => ['nullable', 'string', 'max:100'],
            'subject' => ['required', 'string', 'max:255'],
            'body' => ['nullable', 'string'],
            'letter_type' => ['required', 'string', 'max:100'],
            'unit_code' => ['required', 'string', 'max:50'],
            'status' => ['required', Rule::in(self::STATUS_OPTIONS)],
            'sent_at' => ['nullable', 'date'],
            'approved_by' => ['nullable', 'exists:users,id'],
            'attachment_file' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:10240'],
            'final_file' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:10240'],
            'signature_file' => ['nullable', 'file', 'mimes:png,jpg,jpeg', 'max:5120'],
            'template_id' => ['nullable', 'exists:letter_templates,id'],
        ]);
    }

    private function deleteFile(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    private function shouldGenerateNumber(string $status): bool
    {
        return in_array($status, ['approved', 'sent', 'archived'], true);
    }

    private function resolveYear(?string $sentAt): int
    {
        if ($sentAt) {
            return (int) date('Y', strtotime($sentAt));
        }

        return (int) date('Y');
    }

    private function resolveMonth(?string $sentAt): int
    {
        if ($sentAt) {
            return (int) date('n', strtotime($sentAt));
        }

        return (int) date('n');
    }

    private function generateLetterNumber(int $year, int $month, ?string $jenis, ?string $unit): string
    {
        $instansi = SuratSetting::getValue('instansi', 'UMRIPRESS');
        $format = SuratSetting::getValue('number_format', '{sequence}/{instansi}/{jenis}/{unit}/{bulan_roman}/{tahun}');
        $sequenceLength = (int) SuratSetting::getValue('sequence_length', '3');
        $monthRoman = $this->toRoman($month);

        $placeholders = [
            '{instansi}' => $instansi,
            '{jenis}' => $jenis ?: 'OUT',
            '{unit}' => $unit ?: 'UMUM',
            '{bulan_roman}' => $monthRoman,
            '{bulan}' => str_pad((string) $month, 2, '0', STR_PAD_LEFT),
            '{tahun}' => (string) $year,
        ];

        $prefix = str_replace(array_keys($placeholders), array_values($placeholders), $format);
        $prefix = str_replace('{sequence}', '', $prefix);
        $prefix = ltrim($prefix, '/');
        $prefix = rtrim($prefix, '/');

        $latest = OutgoingLetter::whereNotNull('letter_number')
            ->where('letter_number', 'like', "%{$prefix}%")
            ->orderByDesc('letter_number')
            ->value('letter_number');

        $next = 1;
        if ($latest) {
            $pattern = '/^(\\d{' . $sequenceLength . '}).*' . preg_quote($prefix, '/') . '$/';
            if (preg_match($pattern, $latest, $matches)) {
                $next = (int) $matches[1] + 1;
            }
        }

        $sequence = str_pad((string) $next, $sequenceLength, '0', STR_PAD_LEFT);

        $fullPlaceholders = array_merge($placeholders, ['{sequence}' => $sequence]);
        $formatted = str_replace(array_keys($fullPlaceholders), array_values($fullPlaceholders), $format);

        return $formatted ?: $sequence . '/' . $prefix;
    }

    private function toRoman(int $month): string
    {
        $map = [
            1 => 'I',
            2 => 'II',
            3 => 'III',
            4 => 'IV',
            5 => 'V',
            6 => 'VI',
            7 => 'VII',
            8 => 'VIII',
            9 => 'IX',
            10 => 'X',
            11 => 'XI',
            12 => 'XII',
        ];

        return $map[$month] ?? 'I';
    }

    private function renderTemplate(string $template, array $data): string
    {
        $replacements = [
            'nomor' => $data['letter_number'] ?? '',
            'tanggal' => $data['sent_at'] ?? '',
            'penerima' => $data['recipient'] ?? '',
            'jabatan' => $data['recipient_position'] ?? '',
            'perihal' => $data['subject'] ?? '',
            'isi' => $data['body'] ?? '',
        ];

        foreach ($replacements as $key => $value) {
            $template = preg_replace('/{{\\s*' . preg_quote($key, '/') . '\\s*}}/', (string) $value, $template);
        }

        return $template;
    }

    private function generateVerificationCode(): string
    {
        return strtoupper(bin2hex(random_bytes(8)));
    }

    private function buildQuery(Request $request)
    {
        return OutgoingLetter::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search')->toString();
                $query->where(function ($sub) use ($search) {
                    $sub->where('letter_number', 'like', "%{$search}%")
                        ->orWhere('subject', 'like', "%{$search}%")
                        ->orWhere('recipient', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('recipient'), fn ($query) => $query->where('recipient', 'like', '%' . $request->string('recipient')->toString() . '%'))
            ->when($request->filled('letter_type'), fn ($query) => $query->where('letter_type', 'like', '%' . $request->string('letter_type')->toString() . '%'))
            ->when($request->filled('unit_code'), fn ($query) => $query->where('unit_code', $request->string('unit_code')->toString()))
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')->toString()))
            ->when($request->filled('date_from'), fn ($query) => $query->whereDate('sent_at', '>=', $request->date('date_from')))
            ->when($request->filled('date_to'), fn ($query) => $query->whereDate('sent_at', '<=', $request->date('date_to')));
    }

    private function notifyApproverIfNeeded(OutgoingLetter $letter, ?int $previousApprover, ?string $previousStatus): void
    {
        $shouldNotify = $letter->approved_by && $letter->status === 'draft';
        $changed = $previousApprover !== $letter->approved_by || $previousStatus !== $letter->status;

        if (! $shouldNotify || ($previousApprover !== null && ! $changed)) {
            return;
        }

        SuratNotification::create([
            'user_id' => $letter->approved_by,
            'title' => 'Persetujuan surat keluar',
            'body' => $letter->subject,
            'link' => route('dashboard-surat.outgoing.show', $letter),
        ]);
    }

    private function logAction(int $userId, string $action, int $entityId, array $meta): void
    {
        AuditLog::create([
            'user_id' => $userId,
            'action' => $action,
            'entity_type' => OutgoingLetter::class,
            'entity_id' => $entityId,
            'meta' => $meta,
        ]);
    }
}
