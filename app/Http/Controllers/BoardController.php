<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class BoardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param $id
     * @return Response
     */
    public function index($id): Response
    {
        $boards = Board::whereTeamId($id)->get();
        return response($boards);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'team_id' => 'required',
            'visibility' => 'required'
        ]);

        $path = "";
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
        }

        $board = Board::create([
            'team_id' => $request->team_id,
            'visibility' => $request->visibility,
            'background' => $path != '' ? basename($path) : ''
        ]);

        return \response()->json([
            'board' => $board,
            'message' => "The board was created successfully!"
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return Response
     */
    public function show($id): Response
    {
        $board = Board::findOrFail($id);
        return \response($board);
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
        $board = Board::findOrFail($id);

        $path = '';
        if ($request->hasFile('image')) {
            Storage::disk('public')->delete('/images/'.$board->background_image);
            $path = $request->file('image')->store('images', 'public');
            $board->background_image = $path;
        }

        if ($request->visibility) {
            $board->visibility = $request->visibility;
        }

        $board->save();
        return \response()->json([
            'message' => "The board was updated successfully!"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        Board::destroy($id);
        return \response()->json([
            'message' => "The board was deleted successfully!"
        ]);
    }
}
