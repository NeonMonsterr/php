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
        Schema::create('medicine_data', function (Blueprint $table) {
            $table->id();
            $table->string('batch_no')->unique();
            $table->string('drug_name');
            $table->double('price');
            $table->string('manufacturer');
            $table->integer('stock_qty');
            $table->date('expiry_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicine_data');
    }
};
