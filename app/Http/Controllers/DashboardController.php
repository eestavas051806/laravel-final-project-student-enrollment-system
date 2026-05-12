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
        $enrollmentSubmitted = filled($student->enrollment_submitted_at) || (bool) $student->is_enrolled;

        $profileComplete = filled($student->first_name)
            && filled($student->last_name)
            && filled($student->date_of_birth)
            && filled($student->gender)
            && filled($student->contact_number)
            && filled($student->complete_address)
            && filled($student->course)
            && filled($student->year_level);

        $progressSteps = [
            [
                'label' => 'Account Created',
                'description' => 'Student account is active.',
                'complete' => true,
            ],
            [
                'label' => 'Profile Completed',
                'description' => 'Personal and academic details are ready.',
                'complete' => $profileComplete,
            ],
            [
                'label' => 'Subjects Selected',
                'description' => $enrolledCount > 0
                    ? $enrolledCount . ' subject(s) added.'
                    : 'Choose subjects for this semester.',
                'complete' => $enrolledCount > 0,
            ],
            [
                'label' => 'Submitted for Approval',
                'description' => $enrollmentSubmitted
                    ? 'Enrollment is under admin review.'
                    : 'Submit your selected subjects.',
                'complete' => $enrollmentSubmitted,
            ],
            [
                'label' => 'Admin Approved',
                'description' => $student->is_enrolled
                    ? 'You are officially enrolled.'
                    : 'Waiting for registrar approval.',
                'complete' => (bool) $student->is_enrolled,
            ],
        ];

        $completedSteps = collect($progressSteps)->where('complete', true)->count();
        $progressPercent = (int) round(($completedSteps / count($progressSteps)) * 100);

        return view('dashboard', compact(
            'student',
            'enrollments',
            'totalUnits',
            'totalFee',
            'enrolledCount',
            'progressSteps',
            'completedSteps',
            'progressPercent'
        ));
    }
}
