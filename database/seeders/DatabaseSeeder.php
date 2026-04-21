<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subject;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── SUBJECTS ─────────────────────────────────────────────────────────
        $subjects = [
            // Computer Science
            ['code' => 'CS401',  'name' => 'Software Engineering',           'units' => 3, 'schedule' => 'MWF 8:00–9:00 AM',   'department' => 'Computer Science',       'year_level' => '3rd Year', 'max_slots' => 40, 'fee_per_unit' => 800],
            ['code' => 'CS402',  'name' => 'Database Management Systems',    'units' => 3, 'schedule' => 'TTh 10:00–11:30 AM', 'department' => 'Computer Science',       'year_level' => '3rd Year', 'max_slots' => 40, 'fee_per_unit' => 800],
            ['code' => 'CS403',  'name' => 'Network Security & Cryptography','units' => 3, 'schedule' => 'MWF 1:00–2:00 PM',   'department' => 'Computer Science',       'year_level' => '3rd Year', 'max_slots' => 40, 'fee_per_unit' => 800],
            ['code' => 'CS404',  'name' => 'Machine Learning Fundamentals',  'units' => 3, 'schedule' => 'TTh 1:00–2:30 PM',   'department' => 'Computer Science',       'year_level' => '3rd Year', 'max_slots' => 40, 'fee_per_unit' => 800],
            ['code' => 'CS405',  'name' => 'Operating Systems',              'units' => 3, 'schedule' => 'MWF 10:00–11:00 AM', 'department' => 'Computer Science',       'year_level' => '3rd Year', 'max_slots' => 35, 'fee_per_unit' => 800],
            ['code' => 'CS301',  'name' => 'Data Structures & Algorithms',   'units' => 3, 'schedule' => 'TTh 7:30–9:00 AM',   'department' => 'Computer Science',       'year_level' => '2nd Year', 'max_slots' => 45, 'fee_per_unit' => 800],
            ['code' => 'CS302',  'name' => 'Object-Oriented Programming',    'units' => 3, 'schedule' => 'MWF 2:00–3:00 PM',   'department' => 'Computer Science',       'year_level' => '2nd Year', 'max_slots' => 40, 'fee_per_unit' => 800],
            // Information Technology
            ['code' => 'IT401',  'name' => 'Systems Integration & Architecture', 'units' => 3, 'schedule' => 'MWF 9:00–10:00 AM',  'department' => 'Information Technology', 'year_level' => '3rd Year', 'max_slots' => 40, 'fee_per_unit' => 800],
            ['code' => 'IT402',  'name' => 'Web Development (Advanced)',     'units' => 3, 'schedule' => 'TTh 3:00–4:30 PM',   'department' => 'Information Technology', 'year_level' => '3rd Year', 'max_slots' => 40, 'fee_per_unit' => 800],
            ['code' => 'IT403',  'name' => 'Mobile Application Development', 'units' => 3, 'schedule' => 'MWF 3:00–4:00 PM',   'department' => 'Information Technology', 'year_level' => '3rd Year', 'max_slots' => 35, 'fee_per_unit' => 800],
            // Mathematics
            ['code' => 'MATH02', 'name' => 'Discrete Mathematics',           'units' => 4, 'schedule' => 'TTh 8:00–9:30 AM',   'department' => 'Mathematics',            'year_level' => '2nd Year', 'max_slots' => 50, 'fee_per_unit' => 700],
            ['code' => 'MATH03', 'name' => 'Linear Algebra',                 'units' => 3, 'schedule' => 'MWF 11:00–12:00 PM', 'department' => 'Mathematics',            'year_level' => '2nd Year', 'max_slots' => 50, 'fee_per_unit' => 700],
            // General Education
            ['code' => 'GE101',  'name' => 'Ethics & Social Responsibility', 'units' => 3, 'schedule' => 'MWF 10:00–11:00 AM', 'department' => 'General Education',      'year_level' => '1st Year', 'max_slots' => 60, 'fee_per_unit' => 600],
            ['code' => 'GE102',  'name' => 'Purposive Communication',        'units' => 3, 'schedule' => 'TTh 12:00–1:30 PM',  'department' => 'General Education',      'year_level' => '1st Year', 'max_slots' => 60, 'fee_per_unit' => 600],
            ['code' => 'GE103',  'name' => 'The Contemporary World',         'units' => 3, 'schedule' => 'MWF 12:00–1:00 PM',  'department' => 'General Education',      'year_level' => '1st Year', 'max_slots' => 55, 'fee_per_unit' => 600],
        ];

        foreach ($subjects as $s) {
            Subject::firstOrCreate(['code' => $s['code']], $s);
        }

        // ── DEMO STUDENT ─────────────────────────────────────────────────────
        Student::firstOrCreate(
            ['email' => 'demo@student.edu.ph'],
            [
                'first_name'       => 'Juan Miguel',
                'last_name'        => 'Dela Cruz',
                'middle_name'      => 'Santos',
                'date_of_birth'    => '2002-05-15',
                'gender'           => 'Male',
                'contact_number'   => '09171234567',
                'complete_address' => '123 Rizal St., Poblacion, Davao City',
                'password'         => Hash::make('password'),
                'course'           => 'BSIT',
                'year_level'       => '3rd Year',
                'student_id'       => '2024-00001',
                'is_enrolled'      => false,
            ]
        );

        $this->command->info('✅ Database seeded: ' . Subject::count() . ' subjects, 1 demo student.');
        $this->command->info('   Demo login → email: demo@student.edu.ph | password: password');
    }
}
