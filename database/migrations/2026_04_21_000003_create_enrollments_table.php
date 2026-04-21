<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade');
            $table->string('academic_year', 20)->default('2025-2026');
            $table->string('semester', 30)->default('2nd Semester');
            $table->enum('status', ['enrolled', 'waitlisted', 'dropped'])->default('enrolled');
            $table->unique(['student_id', 'subject_id', 'academic_year', 'semester']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
