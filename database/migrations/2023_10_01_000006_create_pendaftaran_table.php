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
        Schema::create('pendaftaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasien_id')->constrained('pasien')->onDelete('cascade');
            $table->foreignId('poli_id')->constrained('poli');
            $table->foreignId('dokter_id')->nullable()->constrained('dokter');
            $table->date('tanggal_pendaftaran');
            $table->integer('no_antrian');
            $table->enum('status_kehadiran', ['belum hadir', 'sudah hadir'])->default('belum hadir');
            $table->timestamp('waktu_hadir')->nullable();
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftaran');
    }
};
