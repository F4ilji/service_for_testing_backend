<?php

namespace App\Http\Controllers\api\quest;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Models\DifficultlyQuest;
use App\Http\Controllers\Controller;
use App\Http\Resources\quest\QuestResource;
use App\Http\Resources\quest\DifficultyQuestResource;

class DifficultyQuestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return DifficultyQuestResource::collection(DifficultlyQuest::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return new DifficultyQuestResource(DifficultlyQuest::find($id));
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

    public function quests(string $id)
    {
        return QuestResource::collection(Question::where('difficulty_id', $id)->get());
    }
}
