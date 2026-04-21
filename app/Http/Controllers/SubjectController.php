<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
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

        $subjects     = $query->withCount('enrollments')->get();
        $departments  = Subject::select('department')->distinct()->pluck('department');

        // IDs already enrolled by this student
        $enrolledIds = \App\Models\Enrollment::where('student_id', $studentId)
            ->pluck('subject_id')
            ->toArray();

        return view('subjects.index', compact('subjects', 'departments', 'enrolledIds'));
    }
}
