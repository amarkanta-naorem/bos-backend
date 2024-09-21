<?php

namespace App\Models;

use App\Traits\CreatedUpdatedDeletedBy;
use App\Traits\UserActionable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseLearningPath extends Model
{
    use HasFactory, SoftDeletes, CreatedUpdatedDeletedBy, UserActionable;

    protected $fillable = [
        'learning_path_id',
        'course_id',
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

    public function learningPath()
    {
        return $this->belongsTo(LearningPath::class, 'learning_path_id');
    }
}
