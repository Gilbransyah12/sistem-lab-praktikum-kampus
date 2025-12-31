<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add nim column to users table
        Schema::table('users', function (Blueprint $table) {
            $table->string('nim')->nullable()->unique()->after('username');
        });

        // Change role enum to include mahasiswa
        // For SQLite, we need to recreate the column
        if (DB::getDriverName() === 'sqlite') {
            // SQLite doesn't support modifying columns, so we work around
            Schema::table('users', function (Blueprint $table) {
                $table->string('role_new')->default('instruktur')->after('role');
            });
            
            DB::table('users')->update(['role_new' => DB::raw('role')]);
            
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('role');
            });
            
            Schema::table('users', function (Blueprint $table) {
                $table->renameColumn('role_new', 'role');
            });
        } else {
            // For MySQL/PostgreSQL
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'instruktur', 'mahasiswa') DEFAULT 'instruktur'");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('nim');
        });

        // Revert role enum (simplified - in production would need more care)
        if (DB::getDriverName() !== 'sqlite') {
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'instruktur') DEFAULT 'instruktur'");
        }
    }
};
