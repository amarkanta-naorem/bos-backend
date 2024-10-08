<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseSectionContentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "course_section_id" => $this->course_section_id,
            "title" => $this->title,
            "slug" => $this->slug,
            "content" => $this->content,
            "order" => $this->order
        ];
    }
}
