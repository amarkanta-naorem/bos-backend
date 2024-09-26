<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Http\Requests\Course\CourseRequest;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Course::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CourseRequest $request)
    {
        $user = Auth::user();

        if ($request->hasFile('thumbnail_url')) {
            $courseThumbnailImgFile = $request->file('thumbnail_url');
            $slug = $request->input('slug');
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
            Course::create([
                'instructor_id' => $user->id,
                'title' => $request->input('title'),
                'slug' => $request->input('slug'),
                'short_description' => $request->input('short_description'),
                'long_description' => $request->input('long_description'),
                'thumbnail_url' => $thumbnailPath,
                'price' => $request->has('price') ? $request->input('price') : 0,
                'is_premium' => true,
                'level' => $request->input('level'),
                'duration' => $request->input('duration'),
            ]);
            DB::commit();
            return response()->json(["message" => "Course Created Successful"], 201);
        } catch (\Exception $exception) {
            DB::rollBack();
            report($exception);
            return response()->json([
                "message" => "An error occured. Please try again.",
                "error" => $exception->getMessage()
            ], 401);
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
