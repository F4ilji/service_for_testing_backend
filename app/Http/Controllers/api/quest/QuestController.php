<?php

namespace App\Http\Controllers\api\quest;

use Exception;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\quest\QuestResource;

class QuestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getQuestions($id)
    {
       return QuestResource::collection(Question::where('test_id', $id)->orderBy('id', 'desc')->paginate(10));
    }

    public function index(Request $request)
    {
       return QuestResource::collection(Question::where('test_id', $request->only('test_id'))->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $testId)
    {
        $data = $request->validate([
            'quest' => 'string|required|max:100',
            'score' => 'integer',
        ]);
        $data['test_id'] = $testId;
        $quest = Question::create($data);
        return response([
            'quest' => new QuestResource($quest),
            'message' => 'success',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($testId, $questId)
    {
        return new QuestResource(Question::where('id', $questId)->where('test_id', $testId)->first());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $testId, string $questId)
    {
        $data = $request->validate([
            'quest' => 'string|required',
            'score' => 'integer',
        ]);
        $quest = Question::where('test_id', $testId)->where('id', $questId)->first();

        $quest->update($data);
        return response([
            'quest' => new QuestResource($quest),
            'message' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $testId, string $questId)
    {
        if(Question::where('test_id', $testId)->where('id', $questId)->first()) {
            Question::destroy($questId);
            return response([
                'message' => 'success'
            ]);
        } else {
            throw new Exception('not find');
        }
    }
}
