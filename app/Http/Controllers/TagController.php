<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use http\Env\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function index($id): \Illuminate\Http\Response
    {
        $tags = Tag::whereTaskId($id)->get();
        return \response($tags);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'task_id' => 'required',
            'name' => 'required|string|max:255',
            'color' => 'required'
        ]);

        $tag = Tag::create($request->all());
        return \response()->json([
            'tag' => $tag,
            'message' => 'The tag was created successfully!'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): \Illuminate\Http\Response
    {
        $tag = Tag::findOrFail($id);
        return \response($tag);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  $id
     * @return JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        Tag::findOrFail($id)->update($request->all());
        return \response()->json([
            'message' => 'The tag was updated successfully!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        Tag::destroy($id);
        return \response()->json([
            'message' => 'The tag was deleted successfully!'
        ]);
    }
}
