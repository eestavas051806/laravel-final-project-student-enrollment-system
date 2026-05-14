<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'units',
        'schedule',
        'department',
        'year_level',
        'prerequisite_subject_id',
        'corequisite_subject_id',
        'max_slots',
        'fee_per_unit',
        'description',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function prerequisite()
    {
        return $this->belongsTo(Subject::class, 'prerequisite_subject_id');
    }

    public function corequisite()
    {
        return $this->belongsTo(Subject::class, 'corequisite_subject_id');
    }

    public function getAvailableSlotsAttribute(): int
    {
        return $this->max_slots - $this->enrollments()->whereIn('status', ['submitted', 'enrolled'])->count();
    }

    public function getEnrolledCountAttribute(): int
    {
        return $this->enrollments()->whereIn('status', ['submitted', 'enrolled'])->count();
    }
}
