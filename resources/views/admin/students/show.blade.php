@extends('admin.layout')
@section('title', $student->first_name . ' ' . $student->last_name . ' – Admin')

@push('styles')
<style>
    .detail-card { background: white; border-radius: 14px; border: 1px solid var(--ses-gray-200); padding: 1.75rem; margin-bottom: 1.25rem; }
    .section-head { font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.12em; color: var(--ses-red); padding-bottom: 0.6rem; border-bottom: 1.5px solid #fecaca; margin-bottom: 1rem; }
    .detail-row { display: flex; padding: 0.5rem 0; border-bottom: 1px solid var(--ses-gray-100); font-size: 0.85rem; }
    .detail-row:last-child { border-bottom: none; }
    .detail-label { width: 160px; flex-shrink: 0; color: var(--ses-gray-400); font-size: 0.78rem; font-weight: 500; }
    .detail-val { color: var(--ses-gray-900); flex: 1; }
    .pill { display: inline-block; padding: 2px 9px; border-radius: 20px; font-size: 0.68rem; font-weight: 600; }
    .pill.enrolled { background: #dcfce7; color: #15803d; }
    .pill.pending  { background: #fee2e2; color: #b91c1c; }
    .ses-table { width: 100%; border-collapse: collapse; font-size: 0.83rem; }
    .ses-table th { font-size: 0.65rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--ses-gray-400); font-weight: 600; padding: 0 14px 8px; text-align: left; border-bottom: 1px solid var(--ses-gray-200); }
    .ses-table td { padding: 9px 14px; border-bottom: 1px solid var(--ses-gray-100); color: var(--ses-gray-900); }
    .ses-table tr:last-child td { border-bottom: none; }
    .subj-code { font-weight: 600; color: var(--ses-red); font-family: monospace; font-size: 0.8rem; }
</style>
@endpush

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.25rem;">
    <div>
        <div style="font-family:'DM Serif Display',serif;font-size:1.4rem;color:var(--ses-gray-900);">{{ $student->first_name }} {{ $student->last_name }}</div>
        <div style="font-size:0.75rem;color:var(--ses-gray-400);">Student ID: {{ $student->student_id }}</div>
    </div>
    <div style="display:flex;gap:0.6rem;">
        <a href="{{ route('admin.students.edit', $student) }}" style="padding:8px 16px;background:#eff6ff;color:#2563eb;border-radius:9px;font-size:0.83rem;font-weight:600;text-decoration:none;">✏️ Edit</a>
        <form action="{{ route('admin.students.destroy', $student) }}" method="POST" onsubmit="return confirm('Delete this student?')">
            @csrf @method('DELETE')
            <button type="submit" style="padding:8px 16px;background:#fee2e2;color:#b91c1c;border-radius:9px;font-size:0.83rem;font-weight:600;border:none;cursor:pointer;font-family:'DM Sans',sans-serif;">🗑 Delete</button>
        </form>
        <a href="{{ route('admin.students') }}" style="padding:8px 16px;background:var(--ses-gray-100);color:var(--ses-gray-600);border-radius:9px;font-size:0.83rem;font-weight:500;text-decoration:none;">← Back</a>
    </div>
</div>

<div class="detail-card">
    <div class="section-head">Personal Information</div>
    <div class="detail-row"><span class="detail-label">Full name</span><span class="detail-val">{{ $student->first_name }} {{ $student->middle_name }} {{ $student->last_name }}</span></div>
    <div class="detail-row"><span class="detail-label">Date of birth</span><span class="detail-val">{{ $student->date_of_birth }}</span></div>
    <div class="detail-row"><span class="detail-label">Gender</span><span class="detail-val">{{ $student->gender }}</span></div>
    <div class="detail-row"><span class="detail-label">Email</span><span class="detail-val">{{ $student->email }}</span></div>
    <div class="detail-row"><span class="detail-label">Contact number</span><span class="detail-val">{{ $student->contact_number }}</span></div>
    <div class="detail-row"><span class="detail-label">Address</span><span class="detail-val">{{ $student->complete_address }}</span></div>
</div>

<div class="detail-card">
    <div class="section-head">Academic Information</div>
    <div class="detail-row"><span class="detail-label">Student ID</span><span class="detail-val" style="font-family:monospace;font-weight:600;color:var(--ses-red);">{{ $student->student_id }}</span></div>
    <div class="detail-row"><span class="detail-label">Course</span><span class="detail-val">{{ $student->course }}</span></div>
    <div class="detail-row"><span class="detail-label">Year level</span><span class="detail-val">{{ $student->year_level }}</span></div>
    <div class="detail-row">
        <span class="detail-label">Enrollment status</span>
        <span class="detail-val"><span class="pill {{ $student->is_enrolled ? 'enrolled' : 'pending' }}">{{ $student->is_enrolled ? 'Enrolled' : 'Pending' }}</span></span>
    </div>
</div>

@if($student->enrollments->count() > 0)
<div class="detail-card">
    <div class="section-head">Enrolled Subjects ({{ $student->enrollments->count() }})</div>
    <table class="ses-table">
        <thead><tr><th>Code</th><th>Subject</th><th>Units</th><th>Schedule</th></tr></thead>
        <tbody>
            @foreach($student->enrollments as $e)
            <tr>
                <td><span class="subj-code">{{ $e->subject->code }}</span></td>
                <td>{{ $e->subject->name }}</td>
                <td style="color:var(--ses-gray-400);font-size:0.8rem;">{{ $e->subject->units }}</td>
                <td style="color:var(--ses-gray-400);font-size:0.75rem;">{{ $e->subject->schedule }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif
@endsection
