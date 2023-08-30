<?php

namespace App\Http\Resources;

use App\Models\Question;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;


class FavoriteResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $question = Question::find($this->question_id);

        return [
            'favorite_uuid' => $this->uuid,
            'question' => QuestionResource::make($question),
        ];
    }
}
