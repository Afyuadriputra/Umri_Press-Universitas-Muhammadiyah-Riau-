<?php

namespace Tests\Feature\Surat;

use App\Models\AuditLog;
use App\Models\IncomingLetter;
use App\Models\LetterType;
use App\Models\LetterUnit;
use App\Models\OutgoingLetter;
use App\Models\SuratNotification;
use App\Models\SuratSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SuratFlowTest extends TestCase
{
    use RefreshDatabase;

    private static array $summary = [];

    private function logStep(string $message): void
    {
        fwrite(STDERR, "[SURAT-TEST] {$message}\n");
    }

    private function addSummary(string $title, string $detail): void
    {
        self::$summary[] = "{$title}: {$detail}";
    }

    public static function tearDownAfterClass(): void
    {
        if (! empty(self::$summary)) {
            fwrite(STDERR, "[SURAT-TEST] === Summary Flow ===\n");
            foreach (self::$summary as $line) {
                fwrite(STDERR, "[SURAT-TEST] - {$line}\n");
            }
        }

        parent::tearDownAfterClass();
    }

    private function makeUserWithSuratPermissions(array $permissions, bool $canAccess = true): User
    {
        return User::factory()->create([
            'role' => 'user',
            'can_access_surat' => $canAccess,
            'surat_permissions' => $permissions,
        ]);
    }

    public function test_surat_access_denied_redirects_to_login(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
            'can_access_surat' => false,
        ]);

        $this->logStep("User {$user->id} tanpa akses surat mencoba masuk dashboard-surat.");

        $response = $this->actingAs($user)->get(route('dashboard-surat.index'));

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('error');

        $this->logStep("Akses ditolak dan diarahkan ke login dengan pesan error.");
        $this->addSummary('Access control', 'User tanpa akses surat diarahkan ke login.');
    }

    public function test_incoming_letter_create_and_archive_flow(): void
    {
        $user = $this->makeUserWithSuratPermissions([
            'incoming.view',
            'incoming.create',
            'incoming.update',
        ]);

        $payload = [
            'received_at' => now()->toDateString(),
            'sender' => 'Bagian Keuangan',
            'subject' => 'Permintaan Data',
            'status' => 'baru',
        ];

        $this->logStep("Membuat surat masuk oleh user {$user->id}.");
        $createResponse = $this->actingAs($user)->post(route('dashboard-surat.incoming.store'), $payload);
        $createResponse->assertRedirect();

        $letter = IncomingLetter::first();
        $this->assertNotNull($letter, 'Surat masuk harus tersimpan.');
        $this->assertSame('baru', $letter->status);
        $this->logStep("Surat masuk ID {$letter->id} tersimpan dengan status {$letter->status}.");

        $this->assertDatabaseHas('audit_logs', [
            'action' => 'incoming.create',
            'entity_id' => $letter->id,
        ]);
        $this->logStep("Audit log incoming.create tercatat.");

        $archiveResponse = $this->actingAs($user)->patch(route('dashboard-surat.incoming.archive.store', $letter));
        $archiveResponse->assertRedirect();

        $letter->refresh();
        $this->assertSame('arsip', $letter->status);
        $this->logStep("Surat masuk ID {$letter->id} berhasil diarsipkan.");

        $this->assertDatabaseHas('audit_logs', [
            'action' => 'incoming.archive',
            'entity_id' => $letter->id,
        ]);
        $this->logStep("Audit log incoming.archive tercatat.");
        $this->addSummary('Surat Masuk', 'Create + arsip + audit log berhasil.');
    }

    public function test_outgoing_letter_status_flow_and_archive(): void
    {
        SuratSetting::updateOrCreate(['key' => 'instansi'], ['value' => 'UMRIPRESS']);
        SuratSetting::updateOrCreate(['key' => 'number_format'], ['value' => '{sequence}/{instansi}/{jenis}/{unit}/{bulan_roman}/{tahun}']);
        SuratSetting::updateOrCreate(['key' => 'sequence_length'], ['value' => '3']);

        $type = LetterType::firstOrCreate(
            ['code' => 'SK'],
            ['name' => 'Surat Keluar', 'is_active' => true]
        );
        $unit = LetterUnit::firstOrCreate(
            ['code' => 'ADM'],
            ['name' => 'Administrasi', 'is_active' => true]
        );

        $user = $this->makeUserWithSuratPermissions([
            'outgoing.view',
            'outgoing.create',
            'outgoing.update',
        ]);

        $payload = [
            'recipient' => 'Kantor Mitra',
            'subject' => 'Undangan',
            'letter_type' => $type->code,
            'unit_code' => $unit->code,
            'status' => 'draft',
        ];

        $this->logStep("Membuat surat keluar draft oleh user {$user->id}.");
        $createResponse = $this->actingAs($user)->post(route('dashboard-surat.outgoing.store'), $payload);
        $createResponse->assertRedirect();

        $letter = OutgoingLetter::first();
        $this->assertNotNull($letter, 'Surat keluar harus tersimpan.');
        $this->assertSame('draft', $letter->status);
        $this->assertNull($letter->letter_number, 'Nomor surat belum dibuat saat draft.');
        $this->logStep("Surat keluar ID {$letter->id} tersimpan sebagai draft tanpa nomor.");

        $updatePayload = [
            'recipient' => $letter->recipient,
            'subject' => $letter->subject,
            'letter_type' => $letter->letter_type,
            'unit_code' => $letter->unit_code,
            'status' => 'approved',
        ];

        $this->logStep("Mengubah status surat keluar ID {$letter->id} ke approved.");
        $updateResponse = $this->actingAs($user)->put(route('dashboard-surat.outgoing.update', $letter), $updatePayload);
        $updateResponse->assertRedirect();

        $letter->refresh();
        $this->assertSame('approved', $letter->status);
        $this->assertNotNull($letter->letter_number, 'Nomor surat harus ter-generate saat approved.');
        $this->assertStringNotContainsString('{', $letter->letter_number, 'Nomor surat tidak boleh mengandung placeholder.');
        $this->assertStringNotContainsString('}', $letter->letter_number, 'Nomor surat tidak boleh mengandung placeholder.');
        $this->logStep("Nomor surat ter-generate: {$letter->letter_number}.");

        $archiveResponse = $this->actingAs($user)->patch(route('dashboard-surat.outgoing.archive.store', $letter));
        $archiveResponse->assertRedirect();

        $letter->refresh();
        $this->assertSame('archived', $letter->status);
        $this->logStep("Surat keluar ID {$letter->id} berhasil diarsipkan.");

        $this->assertDatabaseHas('audit_logs', [
            'action' => 'outgoing.archive',
            'entity_id' => $letter->id,
        ]);
        $this->logStep("Audit log outgoing.archive tercatat.");
        $this->addSummary('Surat Keluar', 'Draft → Approved (nomor) → Arsip berhasil.');
    }

    public function test_export_csv_and_pdf_for_incoming_and_outgoing(): void
    {
        $user = $this->makeUserWithSuratPermissions([
            'incoming.view',
            'incoming.export',
            'outgoing.view',
            'outgoing.export',
        ]);

        IncomingLetter::create([
            'received_at' => now()->toDateString(),
            'sender' => 'Sekretariat',
            'subject' => 'Undangan Rapat',
            'status' => 'baru',
            'agenda_number' => '0001',
            'agenda_year' => (int) now()->format('Y'),
            'created_by' => $user->id,
        ]);

        OutgoingLetter::create([
            'recipient' => 'Mitra',
            'subject' => 'Pengumuman',
            'letter_type' => 'SK',
            'unit_code' => 'ADM',
            'status' => 'draft',
            'created_by' => $user->id,
        ]);

        $this->logStep("Menguji export CSV/PDF untuk surat masuk dan surat keluar.");

        $incomingCsv = $this->actingAs($user)->get(route('dashboard-surat.incoming.exportCsv'));
        $incomingCsv->assertOk();
        $this->assertStringContainsString('text/csv', (string) $incomingCsv->headers->get('content-type'));

        $incomingPdf = $this->actingAs($user)->get(route('dashboard-surat.incoming.exportPdf'));
        $incomingPdf->assertOk();
        $incomingPdf->assertSee('Buku Agenda Surat Masuk');

        $outgoingCsv = $this->actingAs($user)->get(route('dashboard-surat.outgoing.exportCsv'));
        $outgoingCsv->assertOk();
        $this->assertStringContainsString('text/csv', (string) $outgoingCsv->headers->get('content-type'));

        $outgoingPdf = $this->actingAs($user)->get(route('dashboard-surat.outgoing.exportPdf'));
        $outgoingPdf->assertOk();
        $outgoingPdf->assertSee('Buku Agenda Surat Keluar');

        $this->addSummary('Export', 'CSV/PDF surat masuk & keluar berhasil diakses.');
    }

    public function test_outgoing_approval_creates_notification(): void
    {
        $creator = $this->makeUserWithSuratPermissions([
            'outgoing.view',
            'outgoing.create',
        ]);

        $approver = User::factory()->create([
            'role' => 'user',
            'can_access_surat' => true,
            'surat_permissions' => ['outgoing.view'],
        ]);

        $payload = [
            'recipient' => 'Kantor Mitra',
            'subject' => 'Permintaan Persetujuan',
            'letter_type' => 'SK',
            'unit_code' => 'ADM',
            'status' => 'draft',
            'approved_by' => $approver->id,
        ];

        $this->logStep("Menguji notifikasi approval untuk surat keluar.");
        $this->actingAs($creator)->post(route('dashboard-surat.outgoing.store'), $payload)->assertRedirect();

        $this->assertDatabaseHas('surat_notifications', [
            'user_id' => $approver->id,
            'title' => 'Persetujuan surat keluar',
        ]);

        $this->addSummary('Notifikasi', 'Approval surat keluar mengirim notifikasi ke approver.');
    }

    public function test_permission_granular_for_incoming_and_outgoing(): void
    {
        $incomingUser = $this->makeUserWithSuratPermissions(['incoming.view']);

        $this->logStep("Menguji permission granular: hanya incoming.view.");
        $this->actingAs($incomingUser)->get(route('dashboard-surat.incoming.index'))->assertOk();
        $this->actingAs($incomingUser)->get(route('dashboard-surat.outgoing.index'))
            ->assertRedirect(route('login'));

        $outgoingUser = $this->makeUserWithSuratPermissions(['outgoing.view']);

        $this->logStep("Menguji permission granular: hanya outgoing.view.");
        $this->actingAs($outgoingUser)->get(route('dashboard-surat.outgoing.index'))->assertOk();
        $this->actingAs($outgoingUser)->get(route('dashboard-surat.incoming.index'))
            ->assertRedirect(route('login'));

        $this->addSummary('Permission', 'Incoming/Outgoing view terpisah sesuai izin.');
    }

    public function test_disposition_flow_and_audit_log(): void
    {
        $creator = $this->makeUserWithSuratPermissions([
            'incoming.view',
            'incoming.disposition',
        ]);

        $recipient = $this->makeUserWithSuratPermissions([
            'disposisi.view',
            'disposisi.update',
        ]);

        $letter = IncomingLetter::create([
            'received_at' => now()->toDateString(),
            'sender' => 'Sekretariat',
            'subject' => 'Instruksi Kegiatan',
            'status' => 'baru',
            'agenda_number' => '0002',
            'agenda_year' => (int) now()->format('Y'),
            'created_by' => $creator->id,
        ]);

        $payload = [
            'to_user_id' => $recipient->id,
            'instruction' => 'Mohon tindak lanjut',
            'note' => 'Prioritas',
        ];

        $this->logStep("Menguji disposisi surat masuk dan audit log.");
        $this->actingAs($creator)->post(route('dashboard-surat.disposisi.store', $letter), $payload)
            ->assertRedirect();

        $this->assertDatabaseHas('dispositions', [
            'incoming_letter_id' => $letter->id,
            'created_by' => $creator->id,
            'status' => 'baru',
        ]);

        $this->assertDatabaseHas('audit_logs', [
            'action' => 'disposition.create',
            'entity_type' => \App\Models\Disposition::class,
        ]);

        $this->assertDatabaseHas('surat_notifications', [
            'user_id' => $recipient->id,
            'title' => 'Disposisi baru',
        ]);

        $disposition = \App\Models\Disposition::first();

        $this->actingAs($recipient)->patch(route('dashboard-surat.disposisi.update', $disposition), [
            'status' => 'selesai',
        ])->assertRedirect();

        $this->assertDatabaseHas('audit_logs', [
            'action' => 'disposition.update_status',
            'entity_id' => $disposition->id,
        ]);

        $this->assertDatabaseHas('surat_notifications', [
            'user_id' => $creator->id,
            'title' => 'Disposisi selesai',
        ]);

        $this->addSummary('Disposisi', 'Create + update status + notifikasi + audit log berhasil.');
    }

    public function test_surat_verification_by_code(): void
    {
        $letter = OutgoingLetter::create([
            'recipient' => 'Mitra Kerja',
            'subject' => 'Verifikasi Surat',
            'letter_type' => 'SK',
            'unit_code' => 'ADM',
            'status' => 'sent',
            'sent_at' => now()->toDateString(),
            'verification_code' => 'TESTVERIFY1234',
        ]);

        $this->logStep("Menguji verifikasi surat via kode.");
        $response = $this->get('/surat/verify/' . $letter->verification_code);
        $response->assertOk();
        $response->assertSee('Surat valid dan terdaftar di sistem UMRI Press.');
        $response->assertSee($letter->verification_code);

        $this->addSummary('Verifikasi', 'Halaman verifikasi menampilkan surat valid sesuai kode.');
    }
}
