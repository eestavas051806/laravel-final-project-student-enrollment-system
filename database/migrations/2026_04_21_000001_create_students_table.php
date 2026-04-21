<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name')->nullable();
            $table->date('date_of_birth');
            $table->enum('gender', ['Male', 'Female', 'Other']);
            $table->string('contact_number', 20);
            $table->text('complete_address');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('course');
            $table->string('year_level', 50);
            $table->string('student_id', 20)->unique();
            $table->string('id_photo')->nullable();
            $table->boolean('is_enrolled')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
