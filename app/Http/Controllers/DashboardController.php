<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $studentId = session('student_id');

        if (! $studentId) {
            return redirect()->route('login');
        }

        $student = Student::with(['enrollments.subject'])->findOrFail($studentId);

        $enrollments   = $student->enrollments;
        $totalUnits    = $enrollments->sum(fn($e) => $e->subject->units ?? 0);
        $totalFee      = $enrollments->sum(fn($e) => ($e->subject->units ?? 0) * ($e->subject->fee_per_unit ?? 800));
        $enrolledCount = $enrollments->count();

        return view('dashboard', compact('student', 'enrollments', 'totalUnits', 'totalFee', 'enrolledCount'));
    }
}
