@extends('admin.layout')
@section('title', 'Students – Admin')

@push('styles')
<style>
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem; }
    .page-title { font-family: 'DM Serif Display', serif; font-size: 1.4rem; color: var(--ses-gray-900); }
    .filter-bar { display: flex; gap: 0.65rem; margin-bottom: 1rem; flex-wrap: wrap; }
    .filter-select, .filter-input { height: 38px; border: 1.5px solid var(--ses-border); border-radius: var(--ses-radius-sm); padding: 0 12px; font-size: 0.82rem; font-family: 'DM Sans', system-ui, sans-serif; background: var(--ses-bg); color: var(--ses-gray-900); outline: none; }
    .filter-input { flex: 1; min-width: 200px; }
    .filter-btn { height: 38px; background: var(--ses-red); color: white; border: none; border-radius: var(--ses-radius-sm); padding: 0 18px; font-size: 0.82rem; font-weight: 600; cursor: pointer; font-family: 'DM Sans', system-ui, sans-serif; }
    .filter-btn:hover { background: var(--ses-red-hover); }
    .students-table-wrap { width: 100%; overflow-x: auto; border-radius: var(--ses-radius-md); box-shadow: var(--ses-shadow-sm); }
    .ses-table { width: 100%; min-width: 1220px; border-collapse: collapse; background: var(--ses-bg); border-radius: var(--ses-radius-md); overflow: hidden; border: 1px solid var(--ses-border); font-size: 0.83rem; table-layout: auto; }
    .ses-table th { background: var(--ses-beige-muted); color: var(--ses-text-soft); font-size: 0.65rem; text-transform: uppercase; letter-spacing: 0.1em; font-weight: 600; padding: 11px 16px; text-align: left; border-bottom: 1px solid var(--ses-border); }
    .ses-table td { padding: 10px 14px; border-bottom: 1px solid var(--ses-gray-100); vertical-align: middle; }
    .ses-table tr:last-child td { border-bottom: none; }
    .ses-table tbody tr:hover td { background: var(--ses-beige); }
    .student-id-col { width: 120px; }
    .name-col { width: 180px; }
    .course-col { width: 90px; }
    .year-col { width: 90px; }
    .email-col { width: 330px; }
    .contact-col { width: 150px; }
    .status-col { width: 150px; text-align: center !important; }
    .actions-col { width: 300px; text-align: center !important; }
    .status-cell { text-align: center; white-space: nowrap; }
    .actions-cell { white-space: nowrap; min-width: 300px; }
    .actions-wrap { display: flex; gap: 8px; align-items: center; justify-content: center; flex-wrap: nowrap; }
    .actions-wrap form { margin: 0; }
    .pill { display: inline-flex; align-items: center; justify-content: center; min-width: 86px; padding: 4px 10px; border-radius: 20px; font-size: 0.68rem; font-weight: 600; white-space: nowrap; line-height: 1.1; }
    .pill.enrolled { background: var(--ses-success-bg); color: var(--ses-success-text); }
    .pill.pending  { background: #fee2e2; color: #b91c1c; }
    .action-btn { display: inline-flex; align-items: center; justify-content: center; min-width: 58px; height: 28px; font-size: 0.75rem; line-height: 1; text-decoration: none; padding: 0 10px; border-radius: 6px; font-weight: 600; border: none; cursor: pointer; font-family: 'DM Sans', sans-serif; }
    .action-btn.view   { color: var(--ses-red); background: var(--ses-red-light); }
    .action-btn.edit   { color: var(--ses-text-soft); background: var(--ses-beige); border: 1px solid var(--ses-border); }
    .action-btn.approve { color: #ffffff; background: var(--ses-red); }
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
@if(session('error'))
    <div class="ses-alert error">{{ session('error') }}</div>
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

<div class="students-table-wrap">
    <table class="ses-table">
        <thead>
            <tr>
                <th class="student-id-col">Student ID</th>
                <th class="name-col">Full name</th>
                <th class="course-col">Course</th>
                <th class="year-col">Year</th>
                <th class="email-col">Email</th>
                <th class="contact-col">Contact</th>
                <th class="status-col">Status</th>
                <th class="actions-col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($students as $student)
            <tr>
                <td style="font-size:0.78rem;color:var(--ses-red);font-weight:700;letter-spacing:0.04em;">{{ $student->student_id }}</td>
                <td style="font-weight:500;">{{ $student->first_name }} {{ $student->last_name }}</td>
                <td>{{ $student->course }}</td>
                <td style="font-size:0.78rem;">{{ $student->year_level }}</td>
                <td style="font-size:0.78rem;color:var(--ses-gray-400);">{{ $student->email }}</td>
                <td style="font-size:0.78rem;color:var(--ses-gray-400);">{{ $student->contact_number }}</td>
                <td class="status-cell">
                    <span class="pill {{ $student->is_enrolled ? 'enrolled' : 'pending' }}">
                        {{ $student->is_enrolled ? 'Approved' : ($student->enrollment_submitted_at ? 'For Approval' : 'Pending') }}
                    </span>
                </td>
                <td class="actions-cell">
                    <div class="actions-wrap">
                        <a href="{{ route('admin.students.show', $student) }}" class="action-btn view">View</a>
                        <a href="{{ route('admin.students.edit', $student) }}" class="action-btn edit">Edit</a>
                        @if(! $student->is_enrolled)
                            <form action="{{ route('admin.students.approve', $student) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="action-btn approve">Approve</button>
                            </form>
                        @endif
                        <form action="{{ route('admin.students.destroy', $student) }}" method="POST" onsubmit="return confirm('Delete this student? This cannot be undone.')">
                            @csrf @method('DELETE')
                            <button type="submit" class="action-btn delete">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="8" style="text-align:center;padding:2rem;color:var(--ses-gray-400);">No students found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top:1rem;">{{ $students->withQueryString()->links() }}</div>
@endsection
