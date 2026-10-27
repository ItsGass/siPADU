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
            $table->string('role', 20)->default('mahasiswa')->index()->after('password');
            $table->string('nim', 30)->nullable()->unique()->after('name');
            $table->string('program_studi', 100)->nullable()->after('nim');
            $table->string('no_hp', 20)->nullable()->after('program_studi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['nim']);
            $table->dropColumn(['role', 'nim', 'program_studi', 'no_hp']);
        });
    }
};
