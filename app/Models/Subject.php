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

    public function getAvailableSlotsAttribute(): int
    {
        return $this->max_slots - $this->enrollments()->count();
    }

    public function getEnrolledCountAttribute(): int
    {
        return $this->enrollments()->count();
    }
}
