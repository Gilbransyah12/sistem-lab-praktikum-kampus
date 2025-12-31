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
        Schema::table('pendaftaran_praktikum', function (Blueprint $table) {
            // Add user_id for tracking who registered (before becoming peserta)
            $table->foreignId('user_id')->nullable()->after('id')->constrained('users')->nullOnDelete();
            
            // Make peserta_id nullable (will be set when approved)
            $table->foreignId('peserta_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftaran_praktikum', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
