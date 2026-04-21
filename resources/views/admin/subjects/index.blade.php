@extends('admin.layout')
@section('title', 'Subjects – Admin')

@push('styles')
<style>
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem; }
    .page-title { font-family: 'DM Serif Display', serif; font-size: 1.4rem; color: var(--ses-gray-900); }
    .btn-add-new { padding: 9px 18px; background: var(--ses-red); color: white; border-radius: 9px; font-size: 0.85rem; font-weight: 600; text-decoration: none; }
    .filter-bar { display: flex; gap: 0.65rem; margin-bottom: 1rem; flex-wrap: wrap; }
    .filter-select, .filter-input { height: 36px; border: 1.5px solid var(--ses-gray-200); border-radius: 8px; padding: 0 12px; font-size: 0.82rem; font-family: 'DM Sans', sans-serif; background: white; color: var(--ses-gray-900); outline: none; }
    .filter-input { flex: 1; min-width: 200px; }
    .filter-btn { height: 36px; background: var(--ses-red); color: white; border: none; border-radius: 8px; padding: 0 16px; font-size: 0.82rem; font-weight: 600; cursor: pointer; font-family: 'DM Sans', sans-serif; }
    .ses-table { width: 100%; border-collapse: collapse; background: white; border-radius: 12px; overflow: hidden; border: 1px solid var(--ses-gray-200); font-size: 0.83rem; }
    .ses-table th { background: #7f1d1d; color: rgba(255,255,255,0.85); font-size: 0.65rem; text-transform: uppercase; letter-spacing: 0.1em; font-weight: 600; padding: 10px 14px; text-align: left; }
    .ses-table td { padding: 10px 14px; border-bottom: 1px solid var(--ses-gray-100); vertical-align: middle; }
    .ses-table tr:last-child td { border-bottom: none; }
    .ses-table tbody tr:hover td { background: var(--ses-red-light); }
    .subj-code { font-weight: 600; color: var(--ses-red); font-family: monospace; font-size: 0.8rem; }
    .dept-pill { display: inline-block; padding: 2px 8px; border-radius: 20px; font-size: 0.68rem; font-weight: 600; background: var(--ses-red-light); color: var(--ses-red); }
    .active-pill { display: inline-block; padding: 2px 8px; border-radius: 20px; font-size: 0.68rem; font-weight: 600; }
    .active-pill.yes { background: #dcfce7; color: #15803d; }
    .active-pill.no  { background: #f3f4f6; color: #6b7280; }
    .action-btn { font-size: 0.75rem; text-decoration: none; padding: 3px 9px; border-radius: 6px; font-weight: 600; border: none; cursor: pointer; font-family: 'DM Sans', sans-serif; }
    .action-btn.edit   { color: #2563eb; background: #eff6ff; }
    .action-btn.delete { color: #b91c1c; background: #fee2e2; }
</style>
@endpush

@section('content')
<div class="page-header">
    <div class="page-title">Subjects</div>
    <a href="{{ route('admin.subjects.create') }}" class="btn-add-new">+ Add Subject</a>
</div>

@if(session('success'))
    <div class="ses-alert success">{{ session('success') }}</div>
@endif

<form method="GET" action="{{ route('admin.subjects') }}" class="filter-bar">
    <input type="text" name="search" class="filter-input" placeholder="Search by code or name..." value="{{ request('search') }}">
    <select name="department" class="filter-select">
        <option value="">All departments</option>
        @foreach($departments as $d)
            <option value="{{ $d }}" {{ request('department') == $d ? 'selected' : '' }}>{{ $d }}</option>
        @endforeach
    </select>
    <button type="submit" class="filter-btn">Filter</button>
</form>

<table class="ses-table">
    <thead>
        <tr>
            <th>Code</th>
            <th>Subject name</th>
            <th>Department</th>
            <th>Units</th>
            <th>Year</th>
            <th>Slots</th>
            <th>Fee/unit</th>
            <th>Active</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($subjects as $subject)
        <tr>
            <td><span class="subj-code">{{ $subject->code }}</span></td>
            <td style="font-weight:500;">{{ $subject->name }}</td>
            <td><span class="dept-pill">{{ $subject->department }}</span></td>
            <td style="font-size:0.8rem;color:var(--ses-gray-400);">{{ $subject->units }}</td>
            <td style="font-size:0.78rem;">{{ $subject->year_level }}</td>
            <td style="font-size:0.78rem;">{{ $subject->enrollments_count }}/{{ $subject->max_slots }}</td>
            <td style="font-size:0.78rem;">₱{{ number_format($subject->fee_per_unit) }}</td>
            <td><span class="active-pill {{ $subject->is_active ? 'yes' : 'no' }}">{{ $subject->is_active ? 'Active' : 'Inactive' }}</span></td>
            <td style="display:flex;gap:5px;">
                <a href="{{ route('admin.subjects.edit', $subject) }}" class="action-btn edit">Edit</a>
                <form action="{{ route('admin.subjects.destroy', $subject) }}" method="POST" onsubmit="return confirm('Delete this subject?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="action-btn delete">Delete</button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="9" style="text-align:center;padding:2rem;color:var(--ses-gray-400);">No subjects found.</td></tr>
        @endforelse
    </tbody>
</table>
<div style="margin-top:1rem;">{{ $subjects->withQueryString()->links() }}</div>
@endsection
