<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseEnrollmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "enrollment_id" => $this->enrollment_id,
            "learner" => [
                "id" => $this->learner->id,
                "first_name" => $this->learner->first_name,
                "last_name" => $this->learner->last_name,
                "username" => $this->learner->username,
                "email" => $this->learner->email,
                "phone" => $this->learner->phone,
                "profile_picture" => $this->learner->profile_picture,
            ],
            "course" => [
                'id' => $this->course->id,
                'title' => $this->course->title,
            ],
            "enrolled_at" => $this->enrolled_at,
            "status" => $this->status
        ];
    }
}
