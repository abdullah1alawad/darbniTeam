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

        $answers = $question->question['answers']['wrong'];
        $answers[] = $question->question['answers']['correct'];

        return [
            'favorite_uuid' => $this->uuid,
            'question' => [
                'question_uuid' => $question->uuid,
                'answers' => Collection::wrap($answers)->shuffle()->all(),
                'reference' => $question->reference
            ],
        ];
    }
}
