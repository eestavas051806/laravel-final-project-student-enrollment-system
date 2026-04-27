@extends('admin.layout')
@section('title', 'Edit Student – Admin')

@push('styles')
<style>
    .form-card { background: white; border-radius: 14px; border: 1px solid var(--ses-gray-200); padding: 1.75rem; max-width: 720px; }
    .section-head { font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.12em; color: var(--ses-accent); padding-bottom: 0.6rem; border-bottom: 1.5px solid #c7daee; margin: 1.25rem 0 0.85rem; }
    .ses-label { display: block; font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.06em; color: var(--ses-gray-600); margin-bottom: 4px; }
    .ses-input, .ses-select { width: 100%; height: 40px; border: 1.5px solid var(--ses-gray-200); border-radius: 9px; padding: 0 12px; font-size: 0.87rem; font-family: 'DM Sans', sans-serif; color: var(--ses-gray-900); background: var(--ses-gray-50); outline: none; transition: border-color 0.15s; }
    .ses-input:focus, .ses-select:focus { border-color: var(--ses-accent); background: white; }
    .ses-textarea { width: 100%; border: 1.5px solid var(--ses-gray-200); border-radius: 9px; padding: 10px 12px; font-size: 0.87rem; font-family: 'DM Sans', sans-serif; color: var(--ses-gray-900); background: var(--ses-gray-50); outline: none; resize: vertical; }
    .ses-textarea:focus { border-color: var(--ses-accent); background: white; }
    .btn-save { height: 42px; background: var(--ses-red); color: white; border: none; border-radius: 9px; font-size: 0.87rem; font-weight: 600; padding: 0 1.5rem; cursor: pointer; font-family: 'DM Sans', sans-serif; }
    .btn-cancel { height: 42px; background: var(--ses-gray-100); color: var(--ses-gray-600); border: 1.5px solid var(--ses-gray-200); border-radius: 9px; font-size: 0.87rem; font-weight: 500; padding: 0 1.5rem; text-decoration: none; display: inline-flex; align-items: center; }
</style>
@endpush

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.25rem;">
    <div style="font-family:'DM Serif Display',serif;font-size:1.4rem;color:var(--ses-gray-900);">Edit Student</div>
    <a href="{{ route('admin.students.show', $student) }}" class="btn-cancel">← Back</a>
</div>

@if($errors->any())
    <div class="ses-alert error" style="max-width:720px;">
        <ul style="margin:0;padding-left:1rem;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
@endif

<div class="form-card">
    <form action="{{ route('admin.students.update', $student) }}" method="POST">
        @csrf @method('PATCH')

        <div class="section-head">Personal Information</div>
        <div class="row g-3">
            <div class="col-md-6"><label class="ses-label">First name *</label><input type="text" name="first_name" class="ses-input" value="{{ old('first_name', $student->first_name) }}" required></div>
            <div class="col-md-6"><label class="ses-label">Last name *</label><input type="text" name="last_name" class="ses-input" value="{{ old('last_name', $student->last_name) }}" required></div>
            <div class="col-md-6"><label class="ses-label">Middle name</label><input type="text" name="middle_name" class="ses-input" value="{{ old('middle_name', $student->middle_name) }}"></div>
            <div class="col-md-6"><label class="ses-label">Gender</label>
                <select name="gender" class="ses-select">
                    @foreach(['Male','Female','Other'] as $g)
                        <option value="{{ $g }}" {{ old('gender', $student->gender) == $g ? 'selected' : '' }}>{{ $g }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6"><label class="ses-label">Contact number *</label><input type="text" name="contact_number" class="ses-input" value="{{ old('contact_number', $student->contact_number) }}" required></div>
            <div class="col-md-6"><label class="ses-label">Email *</label><input type="email" name="email" class="ses-input" value="{{ old('email', $student->email) }}" required></div>
            <div class="col-12"><label class="ses-label">Complete address *</label><textarea name="complete_address" class="ses-textarea" rows="2" required>{{ old('complete_address', $student->complete_address) }}</textarea></div>
        </div>

        <div class="section-head">Academic Information</div>
        <div class="row g-3">
            <div class="col-md-6"><label class="ses-label">Course *</label>
                <select name="course" class="ses-select" required>
                    @foreach(['BSIT','BSCS','BSECE','BSEE','BSCpE','BSME','BSCE'] as $c)
                        <option value="{{ $c }}" {{ old('course', $student->course) == $c ? 'selected' : '' }}>{{ $c }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6"><label class="ses-label">Year level *</label>
                <select name="year_level" class="ses-select" required>
                    @foreach(['1st Year','2nd Year','3rd Year','4th Year'] as $y)
                        <option value="{{ $y }}" {{ old('year_level', $student->year_level) == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12">
                <div class="form-check">
                    <input type="checkbox" name="is_enrolled" id="is_enrolled" class="form-check-input" {{ old('is_enrolled', $student->is_enrolled) ? 'checked' : '' }}>
                    <label for="is_enrolled" class="form-check-label" style="font-size:0.87rem;">Mark as officially enrolled</label>
                </div>
            </div>
        </div>

        <div style="display:flex;gap:0.75rem;margin-top:1.5rem;padding-top:1rem;border-top:1px solid var(--ses-gray-200);">
            <button type="submit" class="btn-save">Save changes</button>
            <a href="{{ route('admin.students.show', $student) }}" class="btn-cancel">Cancel</a>
        </div>
    </form>
</div>
@endsection
