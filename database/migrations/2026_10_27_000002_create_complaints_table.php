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
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_number', 30)->unique();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('category', 50)->index();
            $table->string('title');
            $table->text('description');
            $table->string('location')->nullable();
            $table->date('incident_date')->nullable();
            $table->boolean('is_anonymous')->default(false);
            $table->string('status', 20)->default('baru')->index();
            $table->string('priority', 20)->default('sedang')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
