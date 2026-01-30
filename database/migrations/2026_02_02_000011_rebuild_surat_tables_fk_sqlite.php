<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() !== 'sqlite') {
            return;
        }

        DB::statement('PRAGMA foreign_keys=OFF');

        $this->rebuildIncomingLetters();
        $this->rebuildOutgoingLetters();
        $this->rebuildDispositions();
        $this->rebuildDispositionRecipients();
        $this->rebuildSuratNotifications();
        $this->rebuildAuditLogs();

        DB::statement('PRAGMA foreign_keys=ON');
    }

    public function down(): void
    {
        if (DB::getDriverName() !== 'sqlite') {
            return;
        }
    }

    private function rebuildIncomingLetters(): void
    {
        $columns = [
            'id',
            'received_at',
            'letter_date',
            'letter_number',
            'agenda_number',
            'agenda_year',
            'sender',
            'subject',
            'summary',
            'status',
            'internal_notes',
            'assigned_user_id',
            'disposition_note',
            'scan_path',
            'attachment_path',
            'created_by',
            'created_at',
            'updated_at',
        ];

        $this->rebuildTable('incoming_letters', function (Blueprint $table) {
            $table->id();
            $table->date('received_at');
            $table->date('letter_date')->nullable();
            $table->string('letter_number')->nullable();
            $table->string('agenda_number')->nullable();
            $table->integer('agenda_year')->nullable();
            $table->string('sender');
            $table->string('subject');
            $table->text('summary')->nullable();
            $table->string('status')->default('baru');
            $table->text('internal_notes')->nullable();
            $table->foreignId('assigned_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('disposition_note')->nullable();
            $table->string('scan_path')->nullable();
            $table->string('attachment_path')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        }, $columns);
    }

    private function rebuildOutgoingLetters(): void
    {
        DB::statement('DROP INDEX IF EXISTS outgoing_letters_verification_code_unique');

        $columns = [
            'id',
            'letter_number',
            'verification_code',
            'recipient',
            'recipient_phone',
            'recipient_position',
            'subject',
            'body',
            'letter_type',
            'unit_code',
            'template_id',
            'status',
            'sent_at',
            'final_file_path',
            'signature_path',
            'signed_at',
            'attachment_path',
            'created_by',
            'approved_by',
            'created_at',
            'updated_at',
        ];

        $this->rebuildTable('outgoing_letters', function (Blueprint $table) {
            $table->id();
            $table->string('letter_number')->nullable();
            $table->string('verification_code')->nullable()->unique();
            $table->string('recipient');
            $table->string('recipient_phone')->nullable();
            $table->string('recipient_position')->nullable();
            $table->string('subject');
            $table->text('body')->nullable();
            $table->string('letter_type')->nullable();
            $table->string('unit_code')->nullable();
            $table->foreignId('template_id')->nullable();
            $table->string('status')->default('draft');
            $table->date('sent_at')->nullable();
            $table->string('final_file_path')->nullable();
            $table->string('signature_path')->nullable();
            $table->date('signed_at')->nullable();
            $table->string('attachment_path')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        }, $columns);
    }

    private function rebuildDispositions(): void
    {
        $columns = [
            'id',
            'incoming_letter_id',
            'instruction',
            'due_date',
            'note',
            'status',
            'created_by',
            'created_at',
            'updated_at',
        ];

        $this->rebuildTable('dispositions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('incoming_letter_id')->constrained('incoming_letters')->cascadeOnDelete();
            $table->text('instruction')->nullable();
            $table->date('due_date')->nullable();
            $table->text('note')->nullable();
            $table->string('status')->default('baru');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        }, $columns);
    }

    private function rebuildDispositionRecipients(): void
    {
        $columns = [
            'id',
            'disposition_id',
            'user_id',
            'role',
            'created_at',
            'updated_at',
        ];

        $this->rebuildTable('disposition_recipients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('disposition_id')->constrained('dispositions')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('role')->default('to');
            $table->timestamps();
        }, $columns);
    }

    private function rebuildSuratNotifications(): void
    {
        $columns = [
            'id',
            'user_id',
            'title',
            'body',
            'link',
            'read_at',
            'created_at',
            'updated_at',
        ];

        $this->rebuildTable('surat_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->text('body')->nullable();
            $table->string('link')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        }, $columns);
    }

    private function rebuildAuditLogs(): void
    {
        $columns = [
            'id',
            'user_id',
            'action',
            'entity_type',
            'entity_id',
            'meta',
            'created_at',
            'updated_at',
        ];

        $this->rebuildTable('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('action');
            $table->string('entity_type');
            $table->unsignedBigInteger('entity_id')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();
        }, $columns);
    }

    private function rebuildTable(string $table, Closure $create, array $columns): void
    {
        $oldTable = $table . '_old';
        $hasTable = Schema::hasTable($table);
        $hasOld = Schema::hasTable($oldTable);

        if (! $hasTable && ! $hasOld) {
            return;
        }

        if ($hasOld && $hasTable) {
            $this->copyTable($oldTable, $table, $columns, true);
            Schema::drop($oldTable);
            return;
        }

        if ($hasOld && ! $hasTable) {
            Schema::create($table, $create);
            $this->copyTable($oldTable, $table, $columns, false);
            Schema::drop($oldTable);
            return;
        }

        Schema::rename($table, $oldTable);
        Schema::create($table, $create);
        $this->copyTable($oldTable, $table, $columns, false);
        Schema::drop($oldTable);
    }

    private function copyTable(string $from, string $to, array $columns, bool $ignore = false): void
    {
        $columnList = implode(', ', $columns);
        $prefix = $ignore ? 'INSERT OR IGNORE' : 'INSERT';

        DB::statement("{$prefix} INTO {$to} ({$columnList}) SELECT {$columnList} FROM {$from}");
    }
};
