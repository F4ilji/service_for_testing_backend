<?php

namespace App\Http\Controllers\api\quest;

use App\Models\Question;
use App\Models\TypeQuest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\quest\QuestResource;
use App\Http\Resources\quest\TypeQuestResource;

class TypeQuestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return TypeQuestResource::collection(TypeQuest::all());
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
        return new TypeQuestResource(TypeQuest::find($id));
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
        return QuestResource::collection(Question::where('quest_type_id', $id)->get());
    }
}
