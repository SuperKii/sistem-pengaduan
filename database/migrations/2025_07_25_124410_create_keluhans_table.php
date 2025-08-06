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
        Schema::create('keluhan', function (Blueprint $table) {
            $table->id();
            $table->text('deskripsi');
            $table->foreignId('kategori_id')->references('id')->on('kategori')->onDelete('cascade');
            $table->foreignId('penghuni_id')->references('id')->on('penghuni')->onDelete('cascade');
            $table->foreignId('petugas_id')->nullable()->references('id')->on('petugas')->onDelete('cascade');
            $table->string('foto_keluhan');
            $table->string('foto_selfie');
            $table->enum('status',['pending','proses','selesai','ditolak']);
            $table->timestamp('proses_at')->nullable();
            $table->timestamp('selesai_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keluhan');
    }
};
