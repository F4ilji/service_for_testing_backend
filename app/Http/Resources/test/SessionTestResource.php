<?php

namespace App\Http\Resources\test;

use App\Http\Resources\quest\QuestResource;
use App\Models\DifficultlyTest;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SessionTestResource extends JsonResource
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
            'title' => $this->title,
            'difficulty' => new DifficultyResource(DifficultlyTest::find($this->difficulty_id)),
            'questions' => QuestResource::collection($this->questions),
        ];
    }
}
