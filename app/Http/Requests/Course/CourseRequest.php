<?php

namespace App\Http\Requests\Course;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool // Authorize method to restrict access based on user roles
    {
        $user = $this->user(); //Get the authenticated user
        return  $user && in_array($user->role, ['admin', 'instructor']); //Allow access only if the user is an admin or instructor
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'instructor_id' => 'exists:users,id',
            'tag' => 'required|exists:tags,id',
            'title' => 'required|string|max:60',
            'short_description' => 'required|string|max:255',
            'long_description' => 'required|string',
            'thumbnail_url' => 'required|file|mimes:jpeg,jpg,png,gif|max:10240', // 10MB
            // 'is_premium' => 'required|boolean',
            'level' => 'required|in:beginner,intermediate,advanced'
        ];
    }
}
