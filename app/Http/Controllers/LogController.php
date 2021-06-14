<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use function response;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param $id
     * @return Response
     */
    public function index($id): Response
    {
        $logs = Log::whereTaskId($id)->get();
        return response($logs);
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
            'log' => 'required|string|max:255',
        ]);

        $log = Log::create($request->all());
        return response()->json([
            'log' => $log,
            'message' => 'The log was created successfully!'
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
        $log = Log::findOrFail($id);
        return response($log);
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
        Log::findOrFail($id)->update($request->all());
        return response()->json([
            'message' => 'The log was updated successfully!'
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
        Log::destroy($id);
        return response()->json([
            'message' => 'The log was deleted successfully!'
        ]);
    }
}
