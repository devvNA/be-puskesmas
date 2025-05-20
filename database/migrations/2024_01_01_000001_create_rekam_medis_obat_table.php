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
        Schema::create('rekam_medis_obat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rekam_medis_id')->constrained('rekam_medis')->onDelete('cascade');
            $table->foreignId('obat_id')->constrained('obat')->onDelete('cascade');
            $table->integer('jumlah')->default(1);
            $table->string('dosis')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();

            // Index agar pencarian lebih cepat
            $table->index(['rekam_medis_id', 'obat_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekam_medis_obat');
    }
};
