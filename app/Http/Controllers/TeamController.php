<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TeamController extends Controller
{
    /**
     * @param $id
     * @return Application|ResponseFactory|Response
     */
    public function index($id) {
        $teams = Team::whereUserId($id)->get();
        return response($teams);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $team = Team::findOrFail($id);
        $boards = $team->boards();

        return \response()->json([
            'team' => $team,
            'boards' => $boards
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'user_id' => 'required',
            'name' => 'required|string|max:255'
        ]);

        $team = Team::create($request->all());
        return response()->json([
            'team' => $team,
            'message' => 'Team was created successfully!'
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return Application|ResponseFactory|Response
     */
    public function addTeamUser(Request $request, $id) {
        $team = Team::whereId($id)->andWhereUserId($request->userId)->first()->get();

        if (!$team) {
            abort(404, "The team doesn't exist");
        }

        if (!$team->personal_team) {
            $team->users()->attach($request->userToAdd);
        } else {
            return response("This is a personal user team. You don't have access!", 400);
        }

        return response("The user was added to the team successfully!");
    }

    /**
     * @param Request $request
     * @param $id
     * @return Application|ResponseFactory|Response
     */
    public function removeTeamUser(Request $request,$id) {
        $team = Team::whereId($id)->andWhereUserId($request->userId)->first()->get();

        if (!$team) {
            abort(404, "The team doesn't exist");
        }

        if (!$team->personal_team) {
            $team->users()->attach($request->userToRemove);
        } else {
            return response("This is a personal user team. You don't have access!", 400);
        }

        return response("The user was removed to the team successfully!");
    }

    /**
     * @param Request $request
     * @param $id
     * @return Application|ResponseFactory|Response
     */
    public function update(Request $request, $id) {
        $request->validate([
            'name' => 'required'
        ]);

        $team = Team::whereId($id)->andWhereUserId($request->userId)->first()->get();

        if (!$team) {
            abort(404, "The team doesn't exist");
        }

        $team->name = $request->name;
        $team->save();

        return \response("The team was updated successfully!");
    }

    /**
     * @param $id
     * @return Application|ResponseFactory|Response
     */
    public function destroy($id) {
        Team::destroy($id);
        return \response("The team was deleted successfully!");
    }
}
