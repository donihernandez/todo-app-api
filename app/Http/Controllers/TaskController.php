<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param $id
     * @return Response
     */
    public function index($id): Response
    {
        $tasks = Task::whereCardId($id)->get();
        return response($tasks);
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
            'card_id' => 'required',
            'expiration_date' => 'required',
            'name' => 'required|string|max:255',
        ]);

        $task = Task::create($request->all());
        return response()->json([
            'task' => $task,
            'message' => 'The task was created successfully!'
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
        $task = Task::findOrFail($id);
        return response($task);
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
        Task::findOrFail($id)->update($request->all());
        return response()->json([
            'message' => 'The task was updated successfully!'
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
        Task::destroy($id);
        return response()->json([
            'message' => 'The task was deleted successfully!'
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function assignUser(Request $request, $id): JsonResponse
    {
        $task = Task::findOrFail($id);
        $task->users()->attach($request->user);
        return response()->json([
            'message' => 'The user was assigned successfully!'
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function deallocateUser(Request $request, $id): JsonResponse
    {
        $task = Task::findOrFail($id);
        $task->users()->detach($request->user);
        return response()->json([
            'message' => 'The user was deallocated successfully!'
        ]);
    }

}
