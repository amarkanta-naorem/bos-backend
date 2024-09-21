<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseEnrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'learner_id',
        'course_id',
        'enrollment_id',
        'enrolled_at',
        'status'
    ];

    protected $casts = [
        'enrolled_at' => 'datetime',
    ];

    public function learner()
    {
        return $this->belongsTo(User::class, 'learner_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
