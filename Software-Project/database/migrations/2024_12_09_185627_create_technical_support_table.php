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
        Schema::create('technical_support', function (Blueprint $table) {
            $table->id('technician_id');
            $table->string('name');
            $table->json('tickets_assigned')->nullable();
            $table->double('average_resolution_time')->nullable();
            $table->double('customer_satisfaction_rating')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('technical_support');
    }
};
