<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use App\Models\Answer;
use App\Models\Question;
use App\Models\UserAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use App\Http\Resources\test\TestResource;
use App\Http\Resources\quest\QuestResource;
use App\Http\Resources\quest\CategoryResource;
use Illuminate\Http\Resources\Json\JsonResource;

class EndTestUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    
    public function toArray(Request $request): array
    {
        $quests = Question::where('test_id', $this->test->id)->get();
        $max_score = 0;
        foreach($quests as $quest) {
            $max_score += $quest->score;
        }
        return [
            'id' => $this->id,
            'test' => new TestResource($this->test),
            'max_score' => $max_score,
            'score' => $this->score,
            'end_test' => Carbon::parse($this->end_test),
            'created_at' => Carbon::parse($this->created_at),
        ];
    }
}
