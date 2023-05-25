<?php

namespace App\Http\Resources\quest;

use App\Http\Resources\answer\AnswerResource;
use App\Models\Category;
use App\Models\DifficultlyQuest;
use App\Models\TypeQuest;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'quest' => $this->quest,
            'score' => $this->score,
            'answer' => AnswerResource::collection($this->answers),
        ];
    }
}
