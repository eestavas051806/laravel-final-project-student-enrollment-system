<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'middle_name',
        'date_of_birth',
        'gender',
        'contact_number',
        'complete_address',
        'email',
        'password',
        'course',
        'year_level',
        'student_id',
        'id_photo',
        'is_enrolled',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password'    => 'hashed',
            'is_enrolled' => 'boolean',
        ];
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function getFullNameAttribute(): string
    {
        $middle = $this->middle_name ? ' ' . $this->middle_name . ' ' : ' ';
        return $this->first_name . $middle . $this->last_name;
    }

    public function getTotalUnitsAttribute(): int
    {
        return $this->enrollments()
            ->with('subject')
            ->get()
            ->sum(fn($e) => $e->subject->units ?? 0);
    }
}
