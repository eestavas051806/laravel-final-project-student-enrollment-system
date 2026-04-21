@extends('admin.layout')
@section('title', 'Enrollments – Admin')

@push('styles')
<style>
    .page-title { font-family: 'DM Serif Display', serif; font-size: 1.4rem; color: var(--ses-gray-900); margin-bottom: 1.25rem; }
    .ses-table { width: 100%; border-collapse: collapse; background: white; border-radius: 12px; overflow: hidden; border: 1px solid var(--ses-gray-200); font-size: 0.83rem; }
    .ses-table th { background: #7f1d1d; color: rgba(255,255,255,0.85); font-size: 0.65rem; text-transform: uppercase; letter-spacing: 0.1em; font-weight: 600; padding: 10px 14px; text-align: left; }
    .ses-table td { padding: 10px 14px; border-bottom: 1px solid var(--ses-gray-100); vertical-align: middle; }
    .ses-table tr:last-child td { border-bottom: none; }
    .ses-table tbody tr:hover td { background: var(--ses-red-light); }
    .subj-code { font-weight: 600; color: var(--ses-red); font-family: monospace; font-size: 0.8rem; }
    .pill { display: inline-block; padding: 2px 9px; border-radius: 20px; font-size: 0.68rem; font-weight: 600; }
    .pill.enrolled { background: #dcfce7; color: #15803d; }
    .pill.waitlisted { background: #fef9c3; color: #854d0e; }
    .pill.dropped { background: #fee2e2; color: #b91c1c; }
</style>
@endpush

@section('content')
<div class="page-title">All Enrollments</div>

<table class="ses-table">
    <thead>
        <tr>
            <th>#</th>
            <th>Student</th>
            <th>Student ID</th>
            <th>Subject</th>
            <th>Code</th>
            <th>AY / Semester</th>
            <th>Status</th>
            <th>Date enrolled</th>
        </tr>
    </thead>
    <tbody>
        @forelse($enrollments as $e)
        <tr>
            <td style="color:var(--ses-gray-400);font-size:0.75rem;">{{ $e->id }}</td>
            <td style="font-weight:500;">{{ $e->student->first_name }} {{ $e->student->last_name }}</td>
            <td style="font-family:monospace;font-size:0.78rem;color:var(--ses-red);">{{ $e->student->student_id }}</td>
            <td>{{ $e->subject->name }}</td>
            <td><span class="subj-code">{{ $e->subject->code }}</span></td>
            <td style="font-size:0.78rem;color:var(--ses-gray-400);">{{ $e->academic_year }} · {{ $e->semester }}</td>
            <td><span class="pill {{ $e->status }}">{{ ucfirst($e->status) }}</span></td>
            <td style="font-size:0.75rem;color:var(--ses-gray-400);">{{ $e->created_at->format('M d, Y') }}</td>
        </tr>
        @empty
        <tr><td colspan="8" style="text-align:center;padding:2rem;color:var(--ses-gray-400);">No enrollments yet.</td></tr>
        @endforelse
    </tbody>
</table>
<div style="margin-top:1rem;">{{ $enrollments->links() }}</div>
@endsection
