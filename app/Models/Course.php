<?php

namespace App\Models;

use App\Traits\CreatedUpdatedDeletedBy;
use App\Traits\UserActionable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory, SoftDeletes, CreatedUpdatedDeletedBy, UserActionable;

    protected $fillable = [
        'instructor_id',
        'title',
        'slug',
        'short_description',
        'long_description',
        'thumbnail_url',
        'price',
        'is_premium',
        'level',
        'duration',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    protected $dates = ['deleted_at'];

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function courseEnrollments()
    {
        return $this->hasMany(CourseEnrollment::class, 'course_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'course_tag', 'course_id', 'tag_id');
    }

    public function courseSections()
    {
        return $this->hasMany(CourseSection::class, 'course_id');
    }

    public function learningPaths()
    {
        return $this->hasMany(CourseLearningPath::class);
    }
}
