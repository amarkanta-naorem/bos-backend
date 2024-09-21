<?php

namespace App\Models;

use App\Traits\CreatedUpdatedDeletedBy;
use App\Traits\UserActionable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseSection extends Model
{
    use HasFactory, SoftDeletes, CreatedUpdatedDeletedBy, UserActionable;

    protected $fillable = [
        'course_id',
        'title',
        'slug',
        'description',
        'order',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    protected $dates = ['deleted_at'];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function courseSectionContents()
    {
        return $this->hasMany(CourseSectionContent::class, 'course_section_id');
    }
}
