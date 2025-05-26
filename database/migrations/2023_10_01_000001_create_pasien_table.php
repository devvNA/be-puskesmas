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
        Schema::create('pasien', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique()->nullable();
            $table->string('no_rm')->unique()->comment('Nomor Rekam Medis')->nullable();
            $table->string('nik', 16)->unique()->nullable();
            $table->string('no_bpjs')->nullable()->comment('Nomor BPJS');
            $table->enum('jenis', ['Reguler (BPJS)', 'Eksekutif (Non BPJS)'])->nullable();
            $table->string('hubungan_keluarga')->nullable();
            $table->string('nama')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable();
            $table->enum('golongan_darah', ['A', 'B', 'AB', 'O', '-'])->default('-')->nullable();
            $table->text('alamat')->nullable();
            $table->string('rt')->nullable();
            $table->string('rw')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('no_telepon', 15)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasien');
    }
};
