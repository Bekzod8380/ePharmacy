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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('FISH');
            $table->string('passport')->unique();
            $table->date('date_of_birth');
            $table->enum('gender', ['male', 'female'])->index();
            $table->string('address')->nullable();
            $table->string('phone')->unique();
            $table->timestamps();
            $table->index(['FISH', 'phone']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
