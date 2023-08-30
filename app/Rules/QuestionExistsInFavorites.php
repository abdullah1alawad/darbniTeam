<?php

namespace App\Rules;

use App\Models\Favorite;
use App\Models\Question;
use Illuminate\Contracts\Validation\Rule;
use App\traits\GeneralTrait;

class QuestionExistsInFavorites implements Rule
{
    use GeneralTrait;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }


    public function passes($attribute, $value)
    {
        $question = Question::where('uuid', $value)->first();
        if(!$question)
            return $this->notFoundMessage('didnt find the question');

        return !Favorite::where('question_id', $question->id)->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'this question already exists in favorites.';
    }
}
