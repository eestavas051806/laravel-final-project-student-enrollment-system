@extends('admin.layout')
@section('title', 'Edit Subject – Admin')

@push('styles')
<style>
    .form-card { background: white; border-radius: 14px; border: 1px solid var(--ses-gray-200); padding: 1.75rem; max-width: 720px; }
    .section-head { font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.12em; color: var(--ses-accent); padding-bottom: 0.6rem; border-bottom: 1.5px solid #c7daee; margin-bottom: 1rem; }
    .ses-label { display: block; font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.06em; color: var(--ses-gray-600); margin-bottom: 4px; }
    .ses-input, .ses-select { width: 100%; height: 40px; border: 1.5px solid var(--ses-gray-200); border-radius: 9px; padding: 0 12px; font-size: 0.87rem; font-family: 'DM Sans', sans-serif; color: var(--ses-gray-900); background: var(--ses-gray-50); outline: none; transition: border-color 0.15s; }
    .ses-input:focus, .ses-select:focus { border-color: var(--ses-accent); background: white; }
    .ses-textarea { width: 100%; border: 1.5px solid var(--ses-gray-200); border-radius: 9px; padding: 10px 12px; font-size: 0.87rem; font-family: 'DM Sans', sans-serif; color: var(--ses-gray-900); background: var(--ses-gray-50); outline: none; resize: vertical; }
    .btn-save { height: 42px; background: var(--ses-red); color: white; border: none; border-radius: 9px; font-size: 0.87rem; font-weight: 600; padding: 0 1.5rem; cursor: pointer; font-family: 'DM Sans', sans-serif; }
    .btn-cancel { height: 42px; background: var(--ses-gray-100); color: var(--ses-gray-600); border: 1.5px solid var(--ses-gray-200); border-radius: 9px; font-size: 0.87rem; font-weight: 500; padding: 0 1.5rem; text-decoration: none; display: inline-flex; align-items: center; }
</style>
@endpush

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.25rem;">
    <div style="font-family:'DM Serif Display',serif;font-size:1.4rem;color:var(--ses-gray-900);">Edit Subject</div>
    <a href="{{ route('admin.subjects') }}" class="btn-cancel">← Back</a>
</div>

@if($errors->any())
    <div class="ses-alert error" style="max-width:720px;">
        <ul style="margin:0;padding-left:1rem;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
@endif

<div class="form-card">
    <form action="{{ route('admin.subjects.update', $subject) }}" method="POST">
        @csrf @method('PATCH')
        <div class="section-head">Subject Details</div>
        <div class="row g-3">
            <div class="col-md-4"><label class="ses-label">Subject code *</label><input type="text" name="code" class="ses-input" value="{{ old('code', $subject->code) }}" required></div>
            <div class="col-md-8"><label class="ses-label">Subject name *</label><input type="text" name="name" class="ses-input" value="{{ old('name', $subject->name) }}" required></div>
            <div class="col-md-4"><label class="ses-label">Units *</label><input type="number" name="units" class="ses-input" min="1" max="6" value="{{ old('units', $subject->units) }}" required></div>
            <div class="col-md-8"><label class="ses-label">Schedule *</label><input type="text" name="schedule" class="ses-input" value="{{ old('schedule', $subject->schedule) }}" required></div>
            <div class="col-md-6"><label class="ses-label">Department *</label>
                <select name="department" class="ses-select" required>
                    @foreach(['Computer Science','Information Technology','Mathematics','General Education','Engineering'] as $d)
                        <option value="{{ $d }}" {{ old('department', $subject->department) == $d ? 'selected' : '' }}>{{ $d }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6"><label class="ses-label">Year level *</label>
                <select name="year_level" class="ses-select" required>
                    @foreach(['1st Year','2nd Year','3rd Year','4th Year'] as $y)
                        <option value="{{ $y }}" {{ old('year_level', $subject->year_level) == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6"><label class="ses-label">Max slots *</label><input type="number" name="max_slots" class="ses-input" value="{{ old('max_slots', $subject->max_slots) }}" required></div>
            <div class="col-md-6"><label class="ses-label">Fee per unit (₱) *</label><input type="number" name="fee_per_unit" step="0.01" class="ses-input" value="{{ old('fee_per_unit', $subject->fee_per_unit) }}" required></div>
            <div class="col-12"><label class="ses-label">Description</label><textarea name="description" class="ses-textarea" rows="2">{{ old('description', $subject->description) }}</textarea></div>
            <div class="col-12">
                <div class="form-check">
                    <input type="checkbox" name="is_active" id="is_active" class="form-check-input" {{ old('is_active', $subject->is_active) ? 'checked' : '' }}>
                    <label for="is_active" class="form-check-label" style="font-size:0.87rem;">Mark as active (visible to students)</label>
                </div>
            </div>
        </div>
        <div style="display:flex;gap:0.75rem;margin-top:1.5rem;padding-top:1rem;border-top:1px solid var(--ses-gray-200);">
            <button type="submit" class="btn-save">Update subject</button>
            <a href="{{ route('admin.subjects') }}" class="btn-cancel">Cancel</a>
        </div>
    </form>
</div>
@endsection
