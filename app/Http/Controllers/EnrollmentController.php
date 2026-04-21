<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Student;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    // Show enrollment page with subject list
    public function index(Request $request)
    {
        $studentId = session('student_id');

        if (! $studentId) {
            return redirect()->route('login');
        }

        $query = Subject::query()->where('is_active', true);

        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }

        if ($request->filled('year_level')) {
            $query->where('year_level', $request->year_level);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('code', 'like', '%' . $request->search . '%');
            });
        }

        $subjects    = $query->withCount('enrollments')->get();
        $departments = Subject::select('department')->distinct()->pluck('department');

        $student = Student::with(['enrollments.subject'])->findOrFail($studentId);

        $enrolledIds = $student->enrollments->pluck('subject_id')->toArray();
        $totalUnits  = $student->enrollments->sum(fn($e) => $e->subject->units ?? 0);
        $totalFee    = $student->enrollments->sum(fn($e) => ($e->subject->units ?? 0) * ($e->subject->fee_per_unit ?? 800));

        return view('enrollments.index', compact(
            'subjects', 'departments', 'enrolledIds',
            'student', 'totalUnits', 'totalFee'
        ));
    }

    // Add a subject to student's enrollment
    public function store(Request $request)
    {
        $studentId = session('student_id');

        if (! $studentId) {
            return redirect()->route('login');
        }

        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
        ]);

        $subject = Subject::findOrFail($request->subject_id);
        $student = Student::with('enrollments.subject')->findOrFail($studentId);

        // Check if already enrolled
        if ($student->enrollments->pluck('subject_id')->contains($subject->id)) {
            return back()->with('error', 'You are already enrolled in this subject.');
        }

        // Check slot availability
        if ($subject->enrollments()->count() >= $subject->max_slots) {
            return back()->with('error', 'This subject has no available slots.');
        }

        // Check unit cap (24 units max)
        $currentUnits = $student->enrollments->sum(fn($e) => $e->subject->units ?? 0);
        if ($currentUnits + $subject->units > 24) {
            return back()->with('error', 'Adding this subject would exceed the 24-unit limit.');
        }

        Enrollment::create([
            'student_id'    => $studentId,
            'subject_id'    => $subject->id,
            'academic_year' => '2025-2026',
            'semester'      => '2nd Semester',
            'status'        => 'enrolled',
        ]);

        return back()->with('success', '"' . $subject->name . '" has been added to your enrollment.');
    }

    // Remove a subject from enrollment
    public function destroy($id)
    {
        $studentId = session('student_id');

        if (! $studentId) {
            return redirect()->route('login');
        }

        $enrollment = Enrollment::where('id', $id)
            ->where('student_id', $studentId)
            ->firstOrFail();

        $name = $enrollment->subject->name;
        $enrollment->delete();

        return back()->with('success', '"' . $name . '" has been removed from your enrollment.');
    }

    // Confirm enrollment (lock it in)
    public function confirm()
    {
        $studentId = session('student_id');

        if (! $studentId) {
            return redirect()->route('login');
        }

        $student = Student::findOrFail($studentId);

        if ($student->enrollments()->count() === 0) {
            return back()->with('error', 'You have no subjects to confirm.');
        }

        $student->update(['is_enrolled' => true]);

        return redirect()->route('dashboard')->with('success', 'Enrollment confirmed! You are now officially enrolled.');
    }
}
