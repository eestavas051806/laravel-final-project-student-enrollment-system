<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Student;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    private const ACADEMIC_YEAR = '2025-2026';
    private const SEMESTER = '2nd Semester';

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

        $subjects = $query
            ->with(['prerequisite', 'corequisite'])
            ->withCount([
                'enrollments as reserved_count' => fn($q) => $q->whereIn('status', ['submitted', 'enrolled']),
            ])
            ->get();
        $departments = Subject::select('department')->distinct()->pluck('department');

        $student = Student::with(['enrollments.subject'])->findOrFail($studentId);

        $selectedIds = $student->enrollments->pluck('subject_id')->toArray();
        $totalUnits  = $student->enrollments->sum(fn($e) => $e->subject->units ?? 0);
        $totalFee    = $student->enrollments->sum(fn($e) => ($e->subject->units ?? 0) * ($e->subject->fee_per_unit ?? 800));
        $enrollmentLocked = ($student->enrollment_submitted_at || $student->is_enrolled)
            && $student->enrollments->isNotEmpty();

        return view('enrollments.index', compact(
            'subjects', 'departments', 'selectedIds',
            'student', 'totalUnits', 'totalFee', 'enrollmentLocked'
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

        $subject = Subject::with(['prerequisite', 'corequisite'])->findOrFail($request->subject_id);
        $student = Student::with('enrollments.subject')->findOrFail($studentId);

        $hasExistingSubjects = $student->enrollments->isNotEmpty();

        if (($student->enrollment_submitted_at || $student->is_enrolled) && $hasExistingSubjects) {
            return back()->with('error', 'Your enlistment has already been submitted and can no longer be changed.');
        }

        if (! $hasExistingSubjects && ($student->enrollment_submitted_at || $student->is_enrolled)) {
            $student->forceFill([
                'is_enrolled' => false,
                'enrollment_submitted_at' => null,
            ])->save();
        }

        // Check if already selected
        if ($student->enrollments->pluck('subject_id')->contains($subject->id)) {
            return back()->with('error', 'This subject is already in your enlistment.');
        }

        // Check slot availability
        if ($subject->enrollments()->whereIn('status', ['submitted', 'enrolled'])->count() >= $subject->max_slots) {
            return back()->with('error', 'This subject has no available slots.');
        }

        if (! $this->prerequisiteIsCompleted($student, $subject)) {
            return back()->with('error', 'Cannot enroll: prerequisite not satisfied.');
        }

        // Check unit cap (24 units max)
        $currentUnits = $student->enrollments->sum(fn($e) => $e->subject->units ?? 0);
        if ($currentUnits + $subject->units > 24) {
            return back()->with('error', 'Adding this subject would exceed the 24-unit limit.');
        }

        Enrollment::create([
            'student_id'    => $studentId,
            'subject_id'    => $subject->id,
            'academic_year' => self::ACADEMIC_YEAR,
            'semester'      => self::SEMESTER,
            'status'        => 'enlisted',
        ]);

        return back()->with('success', '"' . $subject->name . '" has been added to your enlistment.');
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

        $student = Student::findOrFail($studentId);

        if ($student->enrollment_submitted_at || $student->is_enrolled || $enrollment->status !== 'enlisted') {
            return back()->with('error', 'Submitted enrollments can no longer be changed.');
        }

        $name = $enrollment->subject->name;
        $enrollment->delete();

        return back()->with('success', '"' . $name . '" has been removed from your enlistment.');
    }

    // Confirm enrollment (lock it in)
    public function confirm()
    {
        $studentId = session('student_id');

        if (! $studentId) {
            return redirect()->route('login');
        }

        $student = Student::with(['enrollments.subject.prerequisite', 'enrollments.subject.corequisite'])->findOrFail($studentId);

        if ($student->enrollments()->count() === 0) {
            return back()->with('error', 'You have no subjects to confirm.');
        }

        if ($student->is_enrolled) {
            return redirect()->route('dashboard')->with('success', 'Your enrollment is already approved.');
        }

        if ($student->enrollment_submitted_at) {
            return redirect()->route('dashboard')->with('success', 'Your enrollment is already submitted for admin approval.');
        }

        $validationMessage = $this->validateReadyForSubmission($student);

        if ($validationMessage) {
            return back()->with('error', $validationMessage);
        }

        $student->update(['enrollment_submitted_at' => now()]);
        $student->enrollments()->where('status', 'enlisted')->update(['status' => 'submitted']);

        return redirect()->route('dashboard')->with('success', 'Enrollment submitted! Please wait for admin approval.');
    }

    private function prerequisiteIsCompleted(Student $student, Subject $subject): bool
    {
        if (! $subject->prerequisite_subject_id) {
            return true;
        }

        return $student->enrollments
            ->where('subject_id', $subject->prerequisite_subject_id)
            ->where('status', 'enrolled')
            ->isNotEmpty();
    }

    private function validateReadyForSubmission(Student $student): ?string
    {
        $selectedIds = $student->enrollments->pluck('subject_id');
        $completedIds = $student->enrollments
            ->where('status', 'enrolled')
            ->pluck('subject_id');

        foreach ($student->enrollments as $enrollment) {
            $subject = $enrollment->subject;

            if ($subject->prerequisite_subject_id && ! $completedIds->contains($subject->prerequisite_subject_id)) {
                return 'Cannot enroll: prerequisite not satisfied.';
            }

            if ($subject->corequisite_subject_id
                && ! $selectedIds->contains($subject->corequisite_subject_id)
                && ! $completedIds->contains($subject->corequisite_subject_id)) {
                return 'Please select the required corequisite subject.';
            }

            $reservedCount = $subject->enrollments()
                ->whereIn('status', ['submitted', 'enrolled'])
                ->where('student_id', '!=', $student->id)
                ->count();

            if ($reservedCount >= $subject->max_slots) {
                return 'This subject has no available slots.';
            }
        }

        return null;
    }
}
