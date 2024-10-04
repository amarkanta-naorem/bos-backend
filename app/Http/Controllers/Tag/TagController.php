<?php

namespace App\Http\Controllers\Tag;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tag\TagRequest;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $page = request()->input('page', 5);
        $cacheKey = 'tags.all';
        $tags = Cache::remember($cacheKey, now()->addMinute(10), function () use ($page) {
            return Tag::paginate($page);
        });
        return TagResource::collection($tags);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TagRequest $request)
    {
        try {
            DB::beginTransaction();
            $tag = Tag::create([
                'title' => $request->input('title'),
            ]);
            DB::commit();
            Cache::forget('tags.all');
            return new TagResource($tag);
        } catch (\Exception $exception) {
            DB::rollBack();
            report($exception);
            return response()->json([
                "message" => "An error occured. Please try again.",
                "error" => $exception->getMessage()
            ]);
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
