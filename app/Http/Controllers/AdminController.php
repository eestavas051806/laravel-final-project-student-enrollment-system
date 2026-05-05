<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Subject;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // ── AUTH ──────────────────────────────────────────────────────────────────

    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // Simple hardcoded admin credentials (can be moved to DB later)
        $adminEmail    = config('app.admin_email', 'admin@eduenroll.edu.ph');
        $adminPassword = config('app.admin_password', 'admin123');

        if ($request->email !== $adminEmail || $request->password !== $adminPassword) {
            return back()->withInput()->withErrors(['email' => 'Invalid admin credentials.']);
        }

        session(['admin_logged_in' => true, 'admin_name' => 'Administrator']);

        return redirect()->route('admin.dashboard');
    }

    public function logout()
    {
        session()->forget(['admin_logged_in', 'admin_name']);
        return redirect()->route('admin.login');
    }

    // ── DASHBOARD ─────────────────────────────────────────────────────────────

    public function dashboard()
    {
        if (! session('admin_logged_in')) return redirect()->route('admin.login');

        $totalStudents  = Student::count();
        $enrolledCount  = Student::where('is_enrolled', true)->count();
        $totalSubjects  = Subject::where('is_active', true)->count();
        $totalEnrollments = Enrollment::count();

        $recentStudents = Student::latest()->take(8)->get();

        return view('admin.dashboard', compact(
            'totalStudents', 'enrolledCount', 'totalSubjects',
            'totalEnrollments', 'recentStudents'
        ));
    }

    // ── STUDENTS ──────────────────────────────────────────────────────────────

    public function students(Request $request)
    {
        if (! session('admin_logged_in')) return redirect()->route('admin.login');

        $query = Student::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('first_name', 'like', '%' . $request->search . '%')
                  ->orWhere('last_name', 'like', '%' . $request->search . '%')
                  ->orWhere('student_id', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('course')) {
            $query->where('course', $request->course);
        }

        if ($request->filled('year_level')) {
            $query->where('year_level', $request->year_level);
        }

        $students = $query->latest()->paginate(10);
        $courses  = Student::select('course')->distinct()->pluck('course');

        return view('admin.students.index', compact('students', 'courses'));
    }

    public function showStudent(Student $student)
    {
        if (! session('admin_logged_in')) return redirect()->route('admin.login');
        $student->load('enrollments.subject');
        return view('admin.students.show', compact('student'));
    }

    public function editStudent(Student $student)
    {
        if (! session('admin_logged_in')) return redirect()->route('admin.login');
        return view('admin.students.edit', compact('student'));
    }

    public function updateStudent(Request $request, Student $student)
    {
    if (! session('admin_logged_in')) return redirect()->route('admin.login');

    $request->validate([
        'first_name'       => 'required|string|max:255',
        'last_name'        => 'required|string|max:255',
        'middle_name'      => 'nullable|string|max:255',
        'email'            => 'required|email|unique:students,email,' . $student->id,
        'course'           => 'required|string',
        'year_level'       => 'required|string',
        'contact_number'   => 'required|string|max:20',
        'complete_address' => 'required|string',
    ]);

    $student->update([
        'first_name'       => $request->first_name,
        'last_name'        => $request->last_name,
        'middle_name'      => $request->middle_name,
        'email'            => $request->email,
        'course'           => $request->course,
        'year_level'       => $request->year_level,
        'contact_number'   => $request->contact_number,
        'complete_address' => $request->complete_address,
        'is_enrolled'      => $request->has('is_enrolled') ? 1 : 0,
    ]);

    return redirect()->route('admin.students')->with('success', 'Student updated successfully.');
}

    public function destroyStudent(Student $student)
    {
        if (! session('admin_logged_in')) return redirect()->route('admin.login');
        $student->delete();
        return redirect()->route('admin.students')->with('success', 'Student deleted successfully.');
    }

    // ── SUBJECTS ──────────────────────────────────────────────────────────────

    public function subjects(Request $request)
    {
        if (! session('admin_logged_in')) return redirect()->route('admin.login');

        $query = Subject::withCount('enrollments');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('code', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }

        $subjects    = $query->latest()->paginate(10);
        $departments = Subject::select('department')->distinct()->pluck('department');

        return view('admin.subjects.index', compact('subjects', 'departments'));
    }

    public function createSubject()
    {
        if (! session('admin_logged_in')) return redirect()->route('admin.login');
        return view('admin.subjects.create');
    }

    public function storeSubject(Request $request)
    {
        if (! session('admin_logged_in')) return redirect()->route('admin.login');

        $request->validate([
            'code'         => 'required|string|max:20|unique:subjects,code',
            'name'         => 'required|string|max:255',
            'units'        => 'required|integer|min:1|max:6',
            'schedule'     => 'required|string',
            'department'   => 'required|string',
            'year_level'   => 'required|string',
            'max_slots'    => 'required|integer|min:1',
            'fee_per_unit' => 'required|numeric|min:0',
            'description'  => 'nullable|string',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        Subject::create($data);

        return redirect()->route('admin.subjects')->with('success', 'Subject added successfully.');
    }

    public function editSubject(Subject $subject)
    {
        if (! session('admin_logged_in')) return redirect()->route('admin.login');
        return view('admin.subjects.edit', compact('subject'));
    }

    public function updateSubject(Request $request, Subject $subject)
    {
        if (! session('admin_logged_in')) return redirect()->route('admin.login');

        $request->validate([
            'code'         => 'required|string|max:20|unique:subjects,code,' . $subject->id,
            'name'         => 'required|string|max:255',
            'units'        => 'required|integer|min:1|max:6',
            'schedule'     => 'required|string',
            'department'   => 'required|string',
            'year_level'   => 'required|string',
            'max_slots'    => 'required|integer|min:1',
            'fee_per_unit' => 'required|numeric|min:0',
            'description'  => 'nullable|string',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        $subject->update($data);

        return redirect()->route('admin.subjects')->with('success', 'Subject updated successfully.');
    }

    public function destroySubject(Subject $subject)
    {
        if (! session('admin_logged_in')) return redirect()->route('admin.login');
        $subject->delete();
        return redirect()->route('admin.subjects')->with('success', 'Subject deleted.');
    }

    // ── ENROLLMENTS ───────────────────────────────────────────────────────────

    public function enrollments(Request $request)
    {
        if (! session('admin_logged_in')) return redirect()->route('admin.login');

        $enrollments = Enrollment::with(['student', 'subject'])
            ->latest()
            ->paginate(15);

        return view('admin.enrollments', compact('enrollments'));
    }
}
