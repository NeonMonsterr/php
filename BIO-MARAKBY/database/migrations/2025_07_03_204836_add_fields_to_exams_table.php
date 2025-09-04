<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('exams', function (Blueprint $table) {
            if (!Schema::hasColumn('exams', 'type')) {
                $table->enum('type', ['mcq', 'essay', 'mixed'])->default('mcq');
            }

            if (!Schema::hasColumn('exams', 'duration_minutes')) {
                $table->integer('duration_minutes')->default(30);
            }

            if (!Schema::hasColumn('exams', 'start_time')) {
                $table->dateTime('start_time')->nullable();
            }

            if (!Schema::hasColumn('exams', 'end_time')) {
                $table->dateTime('end_time')->nullable();
            }

            if (!Schema::hasColumn('exams', 'show_score_immediately')) {
                $table->boolean('show_score_immediately')->default(false);
            }
        });
    }

    public function down()
    {
        Schema::table('exams', function (Blueprint $table) {
            $table->dropColumn(['type', 'duration_minutes', 'start_time', 'end_time', 'show_score_immediately']);
        });
    }
};
