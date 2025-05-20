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
        Schema::dropIfExists('otp_verifications');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('otp_verifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('otp', 6);
            $table->string('type')->default('login');
            $table->timestamp('expires_at');
            $table->boolean('is_used')->default(false);
            $table->timestamps();
        });
    }
};
