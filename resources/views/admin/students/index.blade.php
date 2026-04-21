@extends('admin.layout')
@section('title', 'Students – Admin')

@push('styles')
<style>
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem; }
    .page-title { font-family: 'DM Serif Display', serif; font-size: 1.4rem; color: var(--ses-gray-900); }
    .filter-bar { display: flex; gap: 0.65rem; margin-bottom: 1rem; flex-wrap: wrap; }
    .filter-select, .filter-input { height: 36px; border: 1.5px solid var(--ses-gray-200); border-radius: 8px; padding: 0 12px; font-size: 0.82rem; font-family: 'DM Sans', sans-serif; background: white; color: var(--ses-gray-900); outline: none; }
    .filter-input { flex: 1; min-width: 200px; }
    .filter-btn { height: 36px; background: var(--ses-red); color: white; border: none; border-radius: 8px; padding: 0 16px; font-size: 0.82rem; font-weight: 600; cursor: pointer; font-family: 'DM Sans', sans-serif; }
    .ses-table { width: 100%; border-collapse: collapse; background: white; border-radius: 12px; overflow: hidden; border: 1px solid var(--ses-gray-200); font-size: 0.83rem; }
    .ses-table th { background: #7f1d1d; color: rgba(255,255,255,0.85); font-size: 0.65rem; text-transform: uppercase; letter-spacing: 0.1em; font-weight: 600; padding: 10px 14px; text-align: left; }
    .ses-table td { padding: 10px 14px; border-bottom: 1px solid var(--ses-gray-100); vertical-align: middle; }
    .ses-table tr:last-child td { border-bottom: none; }
    .ses-table tbody tr:hover td { background: var(--ses-red-light); }
    .pill { display: inline-block; padding: 2px 9px; border-radius: 20px; font-size: 0.68rem; font-weight: 600; }
    .pill.enrolled { background: #dcfce7; color: #15803d; }
    .pill.pending  { background: #fee2e2; color: #b91c1c; }
    .action-btn { font-size: 0.75rem; text-decoration: none; padding: 3px 9px; border-radius: 6px; font-weight: 600; border: none; cursor: pointer; font-family: 'DM Sans', sans-serif; }
    .action-btn.view   { color: var(--ses-red); background: var(--ses-red-light); }
    .action-btn.edit   { color: #2563eb; background: #eff6ff; }
    .action-btn.delete { color: #b91c1c; background: #fee2e2; }
</style>
@endpush

@section('content')
<div class="page-header">
    <div class="page-title">Students</div>
    <span style="font-size:0.78rem;color:var(--ses-gray-400);">{{ $students->total() }} total students</span>
</div>

@if(session('success'))
    <div class="ses-alert success">{{ session('success') }}</div>
@endif

<form method="GET" action="{{ route('admin.students') }}" class="filter-bar">
    <input type="text" name="search" class="filter-input" placeholder="Search by name, ID, or email..." value="{{ request('search') }}">
    <select name="course" class="filter-select">
        <option value="">All courses</option>
        @foreach($courses as $c)
            <option value="{{ $c }}" {{ request('course') == $c ? 'selected' : '' }}>{{ $c }}</option>
        @endforeach
    </select>
    <select name="year_level" class="filter-select">
        <option value="">All year levels</option>
        @foreach(['1st Year','2nd Year','3rd Year','4th Year'] as $y)
            <option value="{{ $y }}" {{ request('year_level') == $y ? 'selected' : '' }}>{{ $y }}</option>
        @endforeach
    </select>
    <button type="submit" class="filter-btn">Filter</button>
</form>

<table class="ses-table">
    <thead>
        <tr>
            <th>Student ID</th>
            <th>Full name</th>
            <th>Course</th>
            <th>Year</th>
            <th>Email</th>
            <th>Contact</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($students as $student)
        <tr>
            <td style="font-family:monospace;font-size:0.78rem;color:var(--ses-red);font-weight:600;">{{ $student->student_id }}</td>
            <td style="font-weight:500;">{{ $student->first_name }} {{ $student->last_name }}</td>
            <td>{{ $student->course }}</td>
            <td style="font-size:0.78rem;">{{ $student->year_level }}</td>
            <td style="font-size:0.78rem;color:var(--ses-gray-400);">{{ $student->email }}</td>
            <td style="font-size:0.78rem;color:var(--ses-gray-400);">{{ $student->contact_number }}</td>
            <td><span class="pill {{ $student->is_enrolled ? 'enrolled' : 'pending' }}">{{ $student->is_enrolled ? 'Enrolled' : 'Pending' }}</span></td>
            <td style="display:flex;gap:5px;align-items:center;">
                <a href="{{ route('admin.students.show', $student) }}" class="action-btn view">View</a>
                <a href="{{ route('admin.students.edit', $student) }}" class="action-btn edit">Edit</a>
                <form action="{{ route('admin.students.destroy', $student) }}" method="POST" onsubmit="return confirm('Delete this student? This cannot be undone.')">
                    @csrf @method('DELETE')
                    <button type="submit" class="action-btn delete">Delete</button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="8" style="text-align:center;padding:2rem;color:var(--ses-gray-400);">No students found.</td></tr>
        @endforelse
    </tbody>
</table>

<div style="margin-top:1rem;">{{ $students->withQueryString()->links() }}</div>
@endsection
