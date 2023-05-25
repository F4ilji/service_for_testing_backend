<?php

namespace App\Http\Controllers\api\answer;

use Exception;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\answer\AnswerResource;
use App\Http\Resources\answer\AdminAnswerResource;

class AnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request,$testId, $questId)
    {
        $questions = Question::where('test_id', $testId)->get();
        $answers = Answer::whereIn('quest_id', $questions->pluck('id'))->where('quest_id', $questId)->get();
        return AdminAnswerResource::collection($answers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $testId, $questId)
    {
        $data = $request->validate([
            'body' => 'string|required|max:50',
            'is_correct' => 'boolean|required|',
        ]);
        $data['quest_id'] = $questId;
        $quest = Question::where('test_id', $testId)->where('id', $questId)->first();
        $answers = $quest->answers;
        foreach($answers as $answer) {
            if((int)$data['is_correct'] === 1 and $answer->is_correct === 1) { // Choose_one
                throw new Exception('There is already one correct answer');
            }
        };
        return response([
            'answer' => new AnswerResource(Answer::create($data)),
            'message' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($testId, $questId, $answerId)
    {
        $questions = Question::where('test_id', $testId)->get();
        $answer = Answer::whereIn('quest_id', $questions->pluck('id'))
        ->where('quest_id', $questId)
        ->where('id', $answerId)
        ->first();
        return new AnswerResource($answer);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $testId, $questId, $answerId)
    {
        $data = $request->validate([
            'body' => 'string|max:50',
            'is_correct' => 'boolean',
        ]);
        $data['quest_id'] = $questId;
        $quest = Question::where('test_id', $testId)->where('id', $questId)->first();
        $answers = $quest->answers;
        foreach($answers as $answer) {
            if($answer->is_correct) { // Choose_one
                throw new Exception('There is already one correct answer');
            }
        };
        $questions = Question::where('test_id', $testId)->get();
        $answer = Answer::whereIn('quest_id', $questions->pluck('id'))
        ->where('quest_id', $questId)
        ->where('id', $answerId)
        ->first();
        $answer->update($data);
        return response([
            'answer' => new AnswerResource($answer),
            'message' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($testId, $questId, $answerId)
    {
        $questions = Question::where('test_id', $testId)->get();
        $answer = Answer::whereIn('quest_id', $questions->pluck('id'))
        ->where('quest_id', $questId)
        ->where('id', $answerId)
        ->first();
        if($answer != '') {
            Answer::destroy($answerId);
            return response([
                'message' => 'success'
            ]);
        } else {
            throw new Exception('not find');
        }
    }
}
