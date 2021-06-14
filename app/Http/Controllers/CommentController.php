<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param $id
     * @return Response
     */
    public function index($id): Response
    {
        $comments = Comment::whereTaskId($id)->get();
        return response($comments);
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
            'user_id' => 'required',
            'comment' => 'required|string|max:255',
        ]);

        $comment = Comment::create($request->all());
        return response()->json([
            'comment' => $comment,
            'message' => 'The comment was created successfully!'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return Response
     */
    public function show($id): Response
    {
        $comment = Comment::findOrFail($id);
        return response($comment);
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
        Comment::findOrFail($id)->update($request->all());
        return response()->json([
            'message' => 'The comment was updated successfully!'
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
        Comment::destroy($id);
        return response()->json([
            'message' => 'The comment was deleted successfully!'
        ]);
    }
}
