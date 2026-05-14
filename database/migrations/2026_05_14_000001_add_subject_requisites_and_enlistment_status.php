<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('subjects', function (Blueprint $table) {
            if (! Schema::hasColumn('subjects', 'prerequisite_subject_id')) {
                $table->foreignId('prerequisite_subject_id')->nullable()->after('year_level')->constrained('subjects')->nullOnDelete();
            }

            if (! Schema::hasColumn('subjects', 'corequisite_subject_id')) {
                $table->foreignId('corequisite_subject_id')->nullable()->after('prerequisite_subject_id')->constrained('subjects')->nullOnDelete();
            }
        });

        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE enrollments MODIFY status ENUM('enlisted','submitted','enrolled','waitlisted','dropped') NOT NULL DEFAULT 'enlisted'");
            DB::table('enrollments')
                ->join('students', 'students.id', '=', 'enrollments.student_id')
                ->where('enrollments.status', 'enrolled')
                ->where('students.is_enrolled', false)
                ->whereNull('students.enrollment_submitted_at')
                ->update(['enrollments.status' => 'enlisted']);

            DB::table('enrollments')
                ->join('students', 'students.id', '=', 'enrollments.student_id')
                ->where('enrollments.status', 'enrolled')
                ->where('students.is_enrolled', false)
                ->whereNotNull('students.enrollment_submitted_at')
                ->update(['enrollments.status' => 'submitted']);
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE enrollments MODIFY status ENUM('enrolled','waitlisted','dropped') NOT NULL DEFAULT 'enrolled'");
        }

        Schema::table('subjects', function (Blueprint $table) {
            if (Schema::hasColumn('subjects', 'corequisite_subject_id')) {
                $table->dropConstrainedForeignId('corequisite_subject_id');
            }

            if (Schema::hasColumn('subjects', 'prerequisite_subject_id')) {
                $table->dropConstrainedForeignId('prerequisite_subject_id');
            }
        });
    }
};
