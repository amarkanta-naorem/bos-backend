<?php

namespace App\Http\Requests\Course;

use Illuminate\Foundation\Http\FormRequest;

class CourseSectionContentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();
        return $user && in_array($user->role, ['admin', 'instructor']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "course_section_id" => "required|exists:course_sections,id",
            'title' => 'required|string|max:60',
            'content' => 'required',
            'order' => 'required'
        ];
    }
}
