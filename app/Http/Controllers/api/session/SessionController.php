<?php

namespace App\Http\Controllers\api\session;

use Exception;
use Carbon\Carbon;
use App\Models\Test;
use App\Models\User;
use App\Models\Answer;
use App\Models\Question;
use App\Models\TestUser;
use App\Models\UserAnswer;
use Illuminate\Http\Request;
use GuzzleHttp\Psr7\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Date;
use App\Http\Resources\TestUserResource;
use App\Http\Resources\test\TestResource;
use App\Http\Resources\EndTestUserResource;

class SessionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function testing()
    {
        return TestUser::where('user_id', auth()->user()->id)->where('end_test', '>', Date::now())->first();

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
        //
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

    public function getUserSession() {
        return new TestUserResource(TestUser::where('user_id', auth()->user()->id)->where('end_test', '>', Date::now())->first());
    }
    public function getUserSessions() {
        return EndTestUserResource::collection(TestUser::where('user_id', auth()->user()->id)->orderBy('id', 'desc')->where('end_test', '<', Date::now())->paginate(10));
    }

    public function startUserSession(Request $request) {
        $test = Test::find($request->only('test_id'))->first();
        $time = Date::now();
        $user = auth()->user();
        $session = TestUser::create([
            'test_id' => $test->id,
            'user_id' => $user->id,
            'end_test' => $time->addHours($test->test_time),
        ]);
        return new TestUserResource($session);
    }

    public function finishUserSession(Request $request) {
        $user = auth()->user();
        $session = TestUser::where('test_id', $request->only('test_id'))
            ->where('user_id', $user->id)
            ->where('end_test', '>', Date::now())
            ->first();
        if ($session != '') {
            $session->end_test = Date::now();
    
            // Calculate score
            $user_answers = UserAnswer::where('session_id', $session->id)
                ->where('user_id', $user->id)
                ->get();
            $score = 0;
            foreach ($user_answers as $user_answer) {
                $question = Question::find($user_answer->quest_id);
                $answer = Answer::find($user_answer->answer_id);
                if ($answer->is_correct) {
                    $score += $question->score;
                }
            }
            $session->score = $score;
            $session->update();

    
            return response([
                'message' => Date::now(),
                'end_test' => $session->end_test,
                'score' => $score,
            ]);
        } else {
            throw new Exception('Условия не выполнены');
        }
    }

    public function addUserAnswer(Request $request) {
        $user = auth()->user();
        $data = $request->all();
        foreach ($data['questions'] as $item) {
            $quest = Question::where('id', $item['quest_id'])->first();
            $answerCur = Answer::where('quest_id', $quest->id)->where('id', $item['answer_id'])->first();
            $userAnswer = UserAnswer::where('session_id', $data['session_id'])
            ->where('test_id', $data['test_id'])->where('quest_id', $quest->id)->first();
            if($quest and $answerCur and !$userAnswer) {
                UserAnswer::create([
                    'session_id' => $data['session_id'],
                    'test_id' => (int)$data['test_id'],
                    'user_id' => $user->id,
                    'quest_id' => $quest->id,
                    'answer_id' => $answerCur->id,
                ]);
            }            
        }
    
        return response()->json(['message' => 'Answers added successfully']);
    }

    

    



}
