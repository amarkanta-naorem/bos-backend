<?php

namespace App\Models;

use App\Traits\CreatedUpdatedDeletedBy;
use App\Traits\UserActionable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseSectionContent extends Model
{
    use HasFactory, SoftDeletes, CreatedUpdatedDeletedBy, UserActionable;

    protected $fillable = [
        'course_section_id',
        'title',
        'slug',
        'content',
        'order',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    protected $dates = ['deleted_at'];

    public function courseSection()
    {
        return $this->belongsTo(CourseSection::class, 'course_section_id');
    }
}
