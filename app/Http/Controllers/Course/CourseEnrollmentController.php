<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Http\Requests\Course\CourseEnrollmentRequest;
use App\Http\Resources\CourseEnrollmentResource;
use App\Models\CourseEnrollment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseEnrollmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CourseEnrollmentRequest $request)
    {
        $pin = mt_rand(100000000000, 999999999999);
        $enrollmentId = str_shuffle($pin);

        $enrolledAt = Carbon::now();

        try {
            DB::beginTransaction();
            $courseEnrollment = CourseEnrollment::create([
                "learner_id" => $request->input("learner_id"),
                "course_id" => $request->input("course_id"),
                "enrollment_id" => $enrollmentId,
                "enrolled_at" => $enrolledAt->toDateTimeString()
            ]);
            $courseEnrollment->update([
                "status" => "completed"
            ]);
            DB::commit();
            return new CourseEnrollmentResource($courseEnrollment);
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
    public function show(CourseEnrollment $courseEnrollment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CourseEnrollment $courseEnrollment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CourseEnrollment $courseEnrollment)
    {
        //
    }
}
