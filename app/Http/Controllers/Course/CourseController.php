<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Http\Requests\Course\CourseRequest;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $request->input('page', 5);
        // Define a unique cache key
        $cacheKey = 'courses.all' . $page;
        // Check if the data is cached, if not, execute the query and cache it
        $courses = Cache::remember($cacheKey, now()->addMinute(10), function () use ($page) {
            return Course::paginate($page);
        });
        return CourseResource::collection($courses);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(CourseRequest $request)
    {
        $user = Auth::user();        
        $slug = Str::slug($request->input('title'));
        $thumbnailPath = null;
        if ($request->hasFile('thumbnail_url')) {
            $courseThumbnailImgFile = $request->file('thumbnail_url');
            $username = $user->username;
            $thumbnailOriginalFileName = $courseThumbnailImgFile->getClientOriginalName();
            $courseThumbnailImgFilePath = "courses/{$username}/{$slug}/thumbnail/{$thumbnailOriginalFileName}";

            // Store the file in the public disk at the specified path
            // '' means the root path in the disk
            $courseThumbnailImgFile->storeAs('', $courseThumbnailImgFilePath, 'public');
            $thumbnailPath = $courseThumbnailImgFilePath;
        }

        try {
            DB::beginTransaction();
            $course = Course::create([
                'instructor_id' => $user->id,
                'title' => $request->input('title'),
                'slug' => $slug,
                'short_description' => $request->input('short_description'),
                'long_description' => $request->input('long_description'),
                'thumbnail_url' => $thumbnailPath,
                'price' => $request->has('price') ? $request->input('price') : 0,
                'is_premium' => true,
                'level' => $request->input('level'),
                'duration' => $request->input('duration'),
            ]);
            $course->tags()->attach($request->input('tag'));
            DB::commit();
            Cache::forget('courses.all'); // Clear the cache for all courses
            return new CourseResource($course);
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
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
