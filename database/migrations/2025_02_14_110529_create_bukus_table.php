<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('buku', function (Blueprint $table) {
            $table->id();
            // author bisa lebih dari satu
            // $table->foreignId('author_id')->constrained('authors')->onDelete('cascade');
            $table->foreignId('kategori_id')->constrained('kategori')->onDelete('cascade');
            $table->string('judul');
            $table->string('slug')->unique();
            $table->text('deskripsi');
            $table->text('sinopsis');
            $table->text('daftar_isi');
            $table->string('cover');
            $table->string('cover_thumbnail')->nullable();
            $table->string('isbn')->unique();
            $table->bigInteger('harga');
            $table->string('institusi')->nullable();
            $table->string('ukuran');
            $table->boolean('ketersediaan')->default(true);
            $table->integer('jumlah_halaman');
            $table->date('tanggal_terbit');
            $table->json('marketplace_links')->nullable();
            $table->boolean('status')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bukus');
    }
};
