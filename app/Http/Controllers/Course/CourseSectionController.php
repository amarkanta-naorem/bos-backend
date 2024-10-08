<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Http\Requests\Course\CourseSectionRequest;
use App\Http\Resources\CourseSectionResource;
use App\Models\CourseSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CourseSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $request->input('page', 5);
        $cacheKey = 'CourseSection.all' . $page;
        $courseSections = Cache::remember($cacheKey, now()->addMinute(10), function () use ($page) {
            return CourseSection::paginate($page);
        });
        return CourseSectionResource::collection($courseSections);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CourseSectionRequest $request)
    {
        $slug = Str::slug($request->input('title'));

        try {
            DB::beginTransaction();
            $courseSection = CourseSection::create([
                'course_id' => $request->input('course_id'),
                'title' => $request->input('title'),
                'slug' => $slug,
                'description' => $request->input('description'),
                'order' => $request->input('order'),
            ]);
            DB::commit();
            Cache::forget('CourseSection.all');
            return new CourseSectionResource($courseSection);
        } catch (\Exception $exception) {
            DB::rollBack();
            report($exception);
            return response()->json([
                "message" => "An error occured. Please try again.",
                "error" => $exception->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(CourseSection $courseSection)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CourseSection $courseSection)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CourseSection $courseSection)
    {
        //
    }
}
