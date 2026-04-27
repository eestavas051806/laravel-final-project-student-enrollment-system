@extends('admin.layout')
@section('title', 'Admin Dashboard – EduEnroll')

@push('styles')
<style>
    .page-title { font-family: 'DM Serif Display', serif; font-size: 1.4rem; color: var(--ses-gray-900); margin-bottom: 0.15rem; }
    .page-sub   { font-size: 0.78rem; color: var(--ses-gray-400); margin-bottom: 1.5rem; }
    .stat-row   { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-bottom: 1.75rem; }
    .stat-card  { background: white; border-radius: 14px; padding: 1.1rem 1.25rem; border: 1px solid var(--ses-gray-200); position: relative; overflow: hidden; }
    .stat-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; }
    .stat-card.c-red::before   { background: var(--ses-red); }
    .stat-card.c-blue::before  { background: var(--ses-accent); }
    .stat-card.c-green::before { background: #e0837a; }
    .stat-card.c-amber::before { background: var(--ses-red-dark); }
    .stat-icon { width: 34px; height: 34px; border-radius: 9px; display: flex; align-items: center; justify-content: center; margin-bottom: 0.65rem; font-size: 15px; }
    .stat-icon.red   { background: var(--ses-red-light); }
    .stat-icon.blue  { background: var(--ses-accent-light); }
    .stat-icon.green { background: #fff3f2; }
    .stat-icon.amber { background: var(--ses-red-light); }
    .stat-num { font-family: 'DM Serif Display', serif; font-size: 1.8rem; color: var(--ses-gray-900); line-height: 1; margin-bottom: 2px; }
    .stat-lbl { font-size: 0.68rem; color: var(--ses-gray-400); font-weight: 500; text-transform: uppercase; letter-spacing: 0.07em; }
    .sec-title { font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: var(--ses-gray-600); margin-bottom: 0.65rem; display: flex; justify-content: space-between; align-items: center; }
    .sec-title a { color: var(--ses-red); text-decoration: none; font-size: 0.7rem; font-weight: 500; }
    .ses-table { width: 100%; border-collapse: collapse; background: white; border-radius: 12px; overflow: hidden; border: 1px solid var(--ses-gray-200); font-size: 0.83rem; }
    .ses-table th { background: var(--ses-red-deep); color: rgba(255,255,255,0.85); font-size: 0.65rem; text-transform: uppercase; letter-spacing: 0.1em; font-weight: 600; padding: 10px 14px; text-align: left; }
    .ses-table td { padding: 10px 14px; border-bottom: 1px solid var(--ses-gray-100); color: var(--ses-gray-900); vertical-align: middle; }
    .ses-table tr:last-child td { border-bottom: none; }
    .ses-table tbody tr:hover td { background: var(--ses-accent-light); }
    .pill { display: inline-block; padding: 2px 9px; border-radius: 20px; font-size: 0.68rem; font-weight: 600; }
    .pill.enrolled { background: var(--ses-accent-light); color: var(--ses-accent-dark); }
    .pill.pending  { background: #fee2e2; color: #b91c1c; }
</style>
@endpush

@section('content')
<div class="page-title">Dashboard</div>
<div class="page-sub">Welcome back, Administrator · EduEnroll Student Enrollment System</div>

@if(session('success'))
    <div class="ses-alert success">{{ session('success') }}</div>
@endif

{{-- STAT CARDS --}}
<div class="stat-row">
    <div class="stat-card c-red">
        <div class="stat-icon red">👨‍🎓</div>
        <div class="stat-num">{{ $totalStudents }}</div>
        <div class="stat-lbl">Total students</div>
    </div>
    <div class="stat-card c-green">
        <div class="stat-icon green">✅</div>
        <div class="stat-num">{{ $enrolledCount }}</div>
        <div class="stat-lbl">Enrolled students</div>
    </div>
    <div class="stat-card c-blue">
        <div class="stat-icon blue">📚</div>
        <div class="stat-num">{{ $totalSubjects }}</div>
        <div class="stat-lbl">Active subjects</div>
    </div>
    <div class="stat-card c-amber">
        <div class="stat-icon amber">📋</div>
        <div class="stat-num">{{ $totalEnrollments }}</div>
        <div class="stat-lbl">Total enrollments</div>
    </div>
</div>

{{-- RECENT STUDENTS --}}
<div class="sec-title">
    Recent students
    <a href="{{ route('admin.students') }}">View all →</a>
</div>
<table class="ses-table">
    <thead>
        <tr>
            <th>Student ID</th>
            <th>Full name</th>
            <th>Course</th>
            <th>Year level</th>
            <th>Email</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($recentStudents as $student)
        <tr>
            <td style="font-size:0.78rem;color:var(--ses-red);font-weight:700;letter-spacing:0.04em;">{{ $student->student_id }}</td>
            <td>{{ $student->first_name }} {{ $student->last_name }}</td>
            <td>{{ $student->course }}</td>
            <td>{{ $student->year_level }}</td>
            <td style="font-size:0.78rem;color:var(--ses-gray-400);">{{ $student->email }}</td>
            <td>
                <span class="pill {{ $student->is_enrolled ? 'enrolled' : 'pending' }}">
                    {{ $student->is_enrolled ? 'Enrolled' : 'Pending' }}
                </span>
            </td>
            <td>
                <a href="{{ route('admin.students.show', $student) }}" style="font-size:0.75rem;color:var(--ses-red);text-decoration:none;margin-right:8px;">View</a>
                <a href="{{ route('admin.students.edit', $student) }}" style="font-size:0.75rem;color:var(--ses-accent);text-decoration:none;">Edit</a>
            </td>
        </tr>
        @empty
        <tr><td colspan="7" style="text-align:center;padding:2rem;color:var(--ses-gray-400);">No students yet.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection
