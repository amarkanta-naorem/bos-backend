<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Count the total number of course_section_contents for all sections in this course
        $sectionContentCount = $this->courseSections->sum(function ($section) {
            return $section->courseSectionContents()->count(); // Assuming a hasMany relationship exists
        });
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'short_description' => $this->short_description,
            'long_description' => $this->long_description,
            'thumbnail_url' => $this->thumbnail_url,
            'level' => $this->level,
            'tags' => TagResource::collection($this->tags),
            'sections' => CourseSectionResource::collection($this->courseSections),
            // 'learning_paths' => CourseLearningPathResource::collection($this->learningPaths),
            'section_content_count' => $sectionContentCount,
            'instructor' => new UserResource($this->instructor),
            'enrollments_count' => $this->courseEnrollments()->count(),
            'is_premium' => $this->is_premium,
            'price' => $this->price,
            'duration' => $this->duration,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
