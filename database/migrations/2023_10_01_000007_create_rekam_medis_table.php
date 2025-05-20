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
        Schema::create('rekam_medis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasien_id')->constrained('pasien')->onDelete('cascade');
            $table->foreignId('pendaftaran_id')->nullable()->constrained('pendaftaran')->onDelete('set null');
            $table->foreignId('dokter_id')->nullable()->constrained('dokter')->onDelete('set null');
            $table->foreignId('poli_id')->nullable()->constrained('poli')->onDelete('set null');
            $table->date('tanggal_periksa');
            $table->text('keluhan');
            $table->text('diagnosis')->nullable();
            $table->text('tindakan')->nullable();
            $table->text('resep')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekam_medis');
    }
};
