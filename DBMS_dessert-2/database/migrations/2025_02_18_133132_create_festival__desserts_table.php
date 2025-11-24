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
        Schema::create('festival__desserts', function (Blueprint $table) {
            $table->foreignId('FestivalID')->nullable()->constrained('festivals', 'FestivalID');
            $table->foreignId('DessertID')->constrained('desserts', 'DessertID');
            $table->primary(['FestivalID', 'DessertID']);
            $table->softDeletes();
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('festival__desserts');
    }
};
