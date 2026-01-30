<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengaturan', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('display_name');
            $table->string('type')->default('text');
            $table->string('group')->default('umum');
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });

        $settings = [
            [
                'key' => 'logo',
                'value' => 'assets/img/logo.png',
                'display_name' => 'Logo Website',
                'type' => 'image',
                'group' => 'umum',
                'keterangan' => 'Logo utama website (Ukuran yang disarankan: 200x60px)',
            ],
            [
                'key' => 'logo-white',
                'value' => 'assets/img/logo-white.png',
                'display_name' => 'Logo Website',
                'type' => 'image',
                'group' => 'umum',
                'keterangan' => 'Logo untuk darkmode (Ukuran yang disarankan: 200x60px)',
            ],
            [
                'key' => 'favicon',
                'value' => 'assets/img/favicon.png',
                'display_name' => 'Favicon',
                'type' => 'image',
                'group' => 'umum',
                'keterangan' => 'Icon website (Ukuran yang disarankan: 32x32px)',
            ],

            // Group Kontak
            [
                'key' => 'address',
                'value' => 'Jl. Tuanku Tambusai, Delima, Kec. Tampan, Kota Pekanbaru, Riau',
                'display_name' => 'Alamat',
                'type' => 'textarea',
                'group' => 'kontak',
                'keterangan' => 'Alamat lengkap',
            ],
            [
                'key' => 'phone',
                'value' => '+628783715150',
                'display_name' => 'Nomor Telepon',
                'type' => 'text',
                'group' => 'kontak',
                'keterangan' => 'Nomor telepon yang dapat dihubungi',
            ],
            [
                'key' => 'email',
                'value' => 'umripres@umri.ac.id',
                'display_name' => 'Email',
                'type' => 'text',
                'group' => 'kontak',
                'keterangan' => 'Alamat email untuk kontak',
            ],

            // template buku
            [
                'key' => 'template-buku-a4',
                'value' => 'assets/template-buku/a4.docx',
                'display_name' => 'Template Buku A4',
                'type' => 'docx',
                'group' => 'template-buku',
                'keterangan' => 'Template buku A4',
            ],
            [
                'key' => 'template-buku-a5',
                'value' => 'assets/template-buku/a5.docx',
                'display_name' => 'Template Buku A5',
                'type' => 'docx',
                'group' => 'template-buku',
                'keterangan' => 'Template buku A5',
            ],
            [
                'key' => 'template-buku-b5',
                'value' => 'assets/template-buku/b5.docx',
                'display_name' => 'Template Buku B5',
                'type' => 'docx',
                'group' => 'template-buku',
                'keterangan' => 'Template buku B5',
            ],
            [
                'key' => 'template-buku-unesco',
                'value' => 'assets/template-buku/unesco.docx',
                'display_name' => 'Template Buku Unesco',
                'type' => 'docx',
                'group' => 'template-buku',
                'keterangan' => 'Template buku Unesco',
            ],

            // sertifikat kerjasama
            [
                'key' => 'sertifikat',
                'value' => 'assets/sertifikat-kerjasama.pdf',
                'display_name' => 'Sertifikat',
                'type' => 'pdf',
                'group' => 'sertifikat',
                'keterangan' => 'Sertifikat kerjasama',
            ],

            // link gform
            [
                'key' => 'gform',
                'value' => 'https://docs.google.com/forms/d/e/1FAIpQLSdsLgRLYKMQonpOCqg2TDfgu0V4bFCyZIgf-Y7FbW3VQbORUg/viewform?usp=sharing',
                'display_name' => 'Link Kirim Naskah',
                'type' => 'text',
                'group' => 'gform',
                'keterangan' => 'Link gform untuk mengirim naskah',
            ],

            // link progress isbn
            [
                'key' => 'progress-isbn',
                'value' => 'https://docs.google.com/spreadsheets/d/1eB8hMFA_lPq9qHU9aHb1QTG5EZ9VAIv5/edit?usp=sharing&ouid=110970955264024363353&rtpof=true&sd=true',
                'display_name' => 'Link Progress ISBN',
                'type' => 'text',
                'group' => 'progress-isbn',
                'keterangan' => 'Link progress isbn',
            ],
            
        ];

        DB::table('pengaturan')->insert($settings);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaturans');
    }
};
