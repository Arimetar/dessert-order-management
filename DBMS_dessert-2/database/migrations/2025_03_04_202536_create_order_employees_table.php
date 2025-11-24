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
        Schema::create('order_employees', function (Blueprint $table) {
            $table->foreignId('EmployeeID')->constrained('Employees', 'EmployeeID');
            $table->foreignId('OrderID')->constrained('Orders', 'OrderID');
            $table->integer('Status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_employees');
    }
};
