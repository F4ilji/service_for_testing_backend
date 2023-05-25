<?php

namespace App\Http\Resources;

use App\Http\Resources\quest\CategoryResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Resources\quest\QuestResource;
use App\Http\Resources\test\TestResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Date;

class TestUserResource extends JsonResource
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
            'test' => new TestResource($this->test),
            'is_actual' => (Date::now() > Date::parse($this->end_test))  ? false : true,
            'end_test' => Carbon::parse($this->end_test),
            'created_at' => Carbon::parse($this->created_at),
        ];
    }
}
