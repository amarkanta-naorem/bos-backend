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
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'short_description' => $this->short_description,
            'long_description' => $this->long_description,
            'thumbnail_url' => $this->thumbnail_url,
            'price' => $this->price,
            'is_premium' => $this->is_premium,
            'level' => $this->level,
            'duration' => $this->duration,
            'created_by' => $this->created_by,
            'instructor' => new UserResource($this->instructor),
            'enrollments_count' => $this->courseEnrollments()->count(),
            // 'tags' => TagResource::collection($this->tags),
            // 'sections' => CourseSectionResource::collection($this->courseSections),
            // 'learning_paths' => CourseLearningPathResource::collection($this->learningPaths),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
