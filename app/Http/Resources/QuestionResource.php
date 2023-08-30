<?php

namespace App\Http\Resources;

use App\Models\Subject;
use Illuminate\Http\Resources\Json\JsonResource;
use App\traits\GeneralTrait;

class QuestionResource extends JsonResource
{
    use GeneralTrait;

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $subject = Subject::find($this->subject_id);

        return [
            'question_uuid' => $this->uuid,
            'subject_uuid' => $subject->id,
            'question' => $this->question,
            'reference' => $this->reference,
            'mark' => $this->mark,
        ];
    }
}
