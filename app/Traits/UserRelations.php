<?php

namespace App\Traits;

use App\Models\Course;
use App\Models\CourseLearningPath;
use App\Models\CourseSection;
use App\Models\CourseSectionContent;
use App\Models\LearningPath;
use App\Models\Tag;

trait UserRelations
{
    public function createdCourses()
    {
        return $this->hasMany(Course::class, 'created_by');
    }

    public function updatedCourses()
    {
        return $this->hasMany(Course::class, 'updated_by');
    }

    public function deletedCourses()
    {
        return $this->hasMany(Course::class, 'deleted_by');
    }

    public function createdTags()
    {
        return $this->hasMany(Tag::class, 'created_by');
    }

    public function updatedTags()
    {
        return $this->hasMany(Tag::class, 'updated_by');
    }

    public function deletedTags()
    {
        return $this->hasMany(Tag::class, 'deleted_by');
    }

    public function createdCourseSections()
    {
        return $this->hasMany(CourseSection::class, 'created_by');
    }

    public function updatedCourseSections()
    {
        return $this->hasMany(CourseSection::class, 'updated_by');
    }

    public function deletedCourseSections()
    {
        return $this->hasMany(CourseSection::class, 'deleted_by');
    }

    public function createdCourseSectionContents()
    {
        return $this->hasMany(CourseSectionContent::class, 'created_by');
    }

    public function updatedCourseSectionContents()
    {
        return $this->hasMany(CourseSectionContent::class, 'updated_by');
    }

    public function deletedCourseSectionContents()
    {
        return $this->hasMany(CourseSectionContent::class, 'deleted_by');
    }

    public function createdLearningPaths()
    {
        return $this->hasMany(LearningPath::class, 'created_by');
    }

    public function updatedLearningPaths()
    {
        return $this->hasMany(LearningPath::class, 'updated_by');
    }

    public function deletedLearningPaths()
    {
        return $this->hasMany(LearningPath::class, 'deleted_by');
    }

    public function createdCourseLearningPaths()
    {
        return $this->hasMany(CourseLearningPath::class, 'created_by');
    }

    public function updatedCourseLearningPaths()
    {
        return $this->hasMany(CourseLearningPath::class, 'updated_by');
    }

    public function deletedCourseLearningPaths()
    {
        return $this->hasMany(CourseLearningPath::class, 'deleted_by');
    }
}
