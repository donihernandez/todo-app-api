<?php

namespace App\Http\Controllers;

use App\Models\Attached;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;


// TODO
class AttachedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param $id
     * @return Response
     */
    public function index($id): Response
    {
        $attacheds = Attached::whereTaskId($id)->get();
        return response($attacheds);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $files = $request->allFiles();
        foreach ($files as $file) {
            $path = $file->store('attachments', 'public');

            Attached::create([
               'task_id' => $request->task_id,
               'name' => basename($path),
               'url' => Storage::disk('s3')->url($path)
            ]);
        }

        return \response()->json([
            'message' => 'All the attachments was created successfully!'
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return StreamedResponse
     */
    public function show($id): StreamedResponse
    {
        $attached = Attached::findOrFail($id);
        return Storage::disk('s3')->response('/attachments', $attached->name);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $attached = Attached::findOrFail($id);
        Storage::disk('s3')->delete('/attachments/'.$attached->name);

        return \response()->json([
            'message' => 'The attachment was deleted successfully!'
        ]);
    }
}
