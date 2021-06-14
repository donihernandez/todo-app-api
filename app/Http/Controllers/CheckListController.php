<?php

namespace App\Http\Controllers;

use App\Models\Checklist;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CheckListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param $id
     * @return Response
     */
    public function index($id): Response
    {
        $checklists = Checklist::whereTaskId($id)->get();
        return response($checklists);
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
            'done' => 'required',
            'description' => 'required|string|max:255',
        ]);

        $checklist = Checklist::create($request->all());
        return response()->json([
            'checklist' => $checklist,
            'message' => 'The checklist was created successfully!'
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
        $checklist = Checklist::findOrFail($id);
        return response($checklist);
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
        Checklist::findOrFail($id)->update($request->all());
        return response()->json([
            'message' => 'The checklist was updated successfully!'
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
        Checklist::destroy($id);
        return response()->json([
            'message' => 'The checklist was deleted successfully!'
        ]);
    }
}
