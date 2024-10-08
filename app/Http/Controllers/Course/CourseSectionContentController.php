<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Http\Requests\Course\CourseSectionContentRequest;
use App\Http\Resources\CourseSectionContentResource;
use App\Models\CourseSectionContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CourseSectionContentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $request->input('page', 5);
        $cacheKey = 'CourseSectionContents.all' . $page;
        $courseSections = Cache::remember($cacheKey, now()->addMinute(10), function () use ($page) {
            return CourseSectionContent::paginate($page);
        });
        return CourseSectionContentResource::collection($courseSections);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CourseSectionContentRequest $request)
    {
        try {
            $slug = Str::slug($request->input("title"));

            DB::beginTransaction();
            $courseSectionContent = CourseSectionContent::create([
                "course_section_id" => $request->input("course_section_id"),
                "title" => $request->input("title"),
                "slug" => $slug,
                "content" => $request->input("content"),
                "order" => $request->input("order")
            ]);
            DB::commit();
            Cache::forget('CourseSectionContents.all');
            return new CourseSectionContentResource($courseSectionContent);
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
    public function show(CourseSectionContent $courseSectionContent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CourseSectionContent $courseSectionContent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CourseSectionContent $courseSectionContent)
    {
        //
    }
}
