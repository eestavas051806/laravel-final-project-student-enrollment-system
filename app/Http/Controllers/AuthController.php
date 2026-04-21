<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Show login form
    public function showLogin()
    {
        return view('auth.login');
    }

    // Handle login
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $student = Student::where('email', $request->email)->first();

        if (! $student || ! Hash::check($request->password, $student->password)) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Invalid email or password.']);
        }

        session(['student_id' => $student->id, 'student_name' => $student->first_name]);

        return redirect()->route('dashboard');
    }

    // Show registration form
    public function showRegister()
    {
        return view('auth.register');
    }

    // Handle registration
    public function register(Request $request)
    {
        $validated = $request->validate([
            'first_name'       => 'required|string|max:255',
            'last_name'        => 'required|string|max:255',
            'middle_name'      => 'nullable|string|max:255',
            'date_of_birth'    => 'required|date',
            'gender'           => 'required|in:Male,Female,Other',
            'contact_number'   => 'required|string|max:20',
            'complete_address' => 'required|string',
            'email'            => 'required|email|unique:students,email|max:255',
            'password'         => 'required|min:8|confirmed',
            'course'           => 'required|string|max:255',
            'year_level'       => 'required|string|max:50',
            'id_photo'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        // Generate student ID: YYYY-XXXXX
        $validated['student_id'] = date('Y') . '-' . str_pad(Student::count() + 1, 5, '0', STR_PAD_LEFT);

        if ($request->hasFile('id_photo')) {
            $validated['id_photo'] = $request->file('id_photo')->store('id_photos', 'public');
        }

        $student = Student::create($validated);

        session(['student_id' => $student->id, 'student_name' => $student->first_name]);

        return redirect()->route('dashboard')->with('success', 'Registration successful! Welcome, ' . $student->first_name . '.');
    }

    // Logout
    public function logout()
    {
        session()->flush();
        return redirect()->route('login');
    }
}
