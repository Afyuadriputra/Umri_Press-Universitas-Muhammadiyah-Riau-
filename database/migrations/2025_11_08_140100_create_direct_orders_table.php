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
        if (Schema::hasTable('direct_orders')) {
            return;
        }

        Schema::create('direct_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buku_id')->constrained('buku')->cascadeOnDelete();
            $table->foreignId('payment_method_id')->constrained('payment_methods');
            $table->string('recipient_name');
            $table->string('recipient_phone');
            $table->string('recipient_email');
            $table->string('address_label')->nullable();
            $table->string('provinsi');
            $table->string('kota');
            $table->string('kecamatan');
            $table->string('kelurahan');
            $table->string('kode_pos', 10)->nullable();
            $table->text('alamat_lengkap');
            $table->unsignedBigInteger('harga_asli');
            $table->unsignedBigInteger('harga_setelah_diskon');
            $table->enum('status', ['pending', 'verified', 'processing', 'shipped', 'completed', 'cancelled'])->default('pending');
            $table->text('catatan_pengguna')->nullable();
            $table->text('catatan_admin')->nullable();
            $table->string('bukti_pembayaran')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('direct_orders');
    }
};
