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
        Schema::create('pharmacy_staff_training', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pharmacy_staff_id')->constrained('pharmacy_staff')->onDelete('cascade');
            $table->foreignId('training_and_support_id')->constrained('training_and_support')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pharmacy_staff_training');
    }
};
