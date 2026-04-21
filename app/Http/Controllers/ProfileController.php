<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        $studentId = session('student_id');
        if (! $studentId) return redirect()->route('login');

        $student = Student::with('enrollments.subject')->findOrFail($studentId);
        return view('profile.show', compact('student'));
    }

    public function edit()
    {
        $studentId = session('student_id');
        if (! $studentId) return redirect()->route('login');

        $student = Student::findOrFail($studentId);
        return view('profile.edit', compact('student'));
    }

    public function update(Request $request)
    {
        $studentId = session('student_id');
        if (! $studentId) return redirect()->route('login');

        $student = Student::findOrFail($studentId);

        $request->validate([
            'first_name'       => 'required|string|max:255',
            'last_name'        => 'required|string|max:255',
            'middle_name'      => 'nullable|string|max:255',
            'contact_number'   => 'required|string|max:20',
            'complete_address' => 'required|string',
            'email'            => 'required|email|unique:students,email,' . $student->id,
        ]);

        $student->update($request->only([
            'first_name', 'last_name', 'middle_name',
            'contact_number', 'complete_address', 'email',
        ]));

        // Update session name
        session(['student_name' => $request->first_name]);

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $studentId = session('student_id');
        if (! $studentId) return redirect()->route('login');

        $student = Student::findOrFail($studentId);

        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:8|confirmed',
        ]);

        if (! Hash::check($request->current_password, $student->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $student->update(['password' => Hash::make($request->password)]);

        return redirect()->route('profile.show')->with('success', 'Password changed successfully.');
    }

    public function updatePhoto(Request $request)
    {
        $studentId = session('student_id');
        if (! $studentId) return redirect()->route('login');

        $request->validate([
            'id_photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $student = Student::findOrFail($studentId);
        $path    = $request->file('id_photo')->store('id_photos', 'public');
        $student->update(['id_photo' => $path]);

        return redirect()->route('profile.show')->with('success', 'Photo updated successfully.');
    }
}
