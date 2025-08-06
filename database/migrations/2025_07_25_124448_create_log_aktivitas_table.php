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
        Schema::create('log_aktivitas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->nullable()->references('id')->on('users');
            $table->foreignId('petugas_id')->nullable()->references('id')->on('petugas');
            $table->foreignId('penghuni_id')->nullable()->references('id')->on('penghuni');
            $table->string('aksi');
            $table->string('tipe_aksi');
            $table->integer('aksi_id');
            $table->text('deskripsi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_aktivitas');
    }
};
