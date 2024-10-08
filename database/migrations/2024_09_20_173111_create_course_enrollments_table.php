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
        Schema::create('course_enrollments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('learner_id');
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('enrollment_id')->unique();
            $table->timestamp('enrolled_at');
            $table->enum('status', ['in_progress', 'completed', 'dropped'])->default('in_progress');
            $table->foreign('learner_id')->references('id')->on('users');
            $table->foreign('course_id')->references('id')->on('courses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_enrollments');
    }
};
