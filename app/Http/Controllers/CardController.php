<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param $id
     * @return Response
     */
    public function index($id): Response
    {
        $cards = Card::whereBoardId($id)->get();
        return response($cards);
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
            'board_id' => 'required',
            'name' => 'required|string|max:255',
        ]);

        $card = Card::create($request->all());
        return response()->json([
            'card' => $card,
            'message' => 'The card was created successfully!'
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
        $card = Card::findOrFail($id);
        return response($card);
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
        Card::findOrFail($id)->update($request->all());
        return response()->json([
            'message' => 'The card was updated successfully!'
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
        Card::destroy($id);
        return response()->json([
            'message' => 'The card was deleted successfully!'
        ]);
    }
}
