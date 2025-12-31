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
        Schema::table('users', function (Blueprint $table) {
            // Drop old name column
            $table->dropColumn('name');
            
            // Add new columns
            $table->string('username')->unique()->after('id');
            $table->string('nama')->after('password');
            $table->string('no_hp_wa')->nullable()->after('nama');
            $table->enum('role', ['admin', 'instruktur'])->default('instruktur')->after('no_hp_wa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['username', 'nama', 'no_hp_wa', 'role']);
            $table->string('name')->after('id');
        });
    }
};
