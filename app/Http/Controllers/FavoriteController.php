<?php

namespace App\Http\Controllers;

use App\Http\Requests\FavoriteRequest;
use App\Http\Resources\FavoriteResource;
use App\Models\Favorite;
use App\Models\Question;
use App\traits\GeneralTrait;
use Illuminate\Support\Str;

class FavoriteController extends Controller
{
    use GeneralTrait;

    public function index(): \Illuminate\Http\JsonResponse
    {
        try {
            $user_id = auth('sanctum')->user()->id;

            $favorites = Favorite::where('user_id', $user_id)->get();
            $favorites = FavoriteResource::collection($favorites);

            return $this->apiResponse($favorites, true, 'all favorites questions.');

        } catch (\Exception $ex) {
            return $this->internalServer($ex->getMessage());
        }
    }


    public function store(FavoriteRequest $request)
    {
        try {
            $user_id = auth('sanctum')->user()->id;
            $question = Question::where('uuid', $request->question_uuid)->select('id')->first();

            Favorite::create([
                'uuid' => Str::uuid(),
                'user_id' => $user_id,
                'question_id' => $question->id,
            ]);

            return $this->apiResponse(null, true, 'the question has been added to the favorites');

        } catch (\Exception $ex) {
            return $this->internalServer($ex->getMessage());
        }
    }

    public function destroy($question_uuid)
    {
        try {
            $question = Question::where('uuid', $question_uuid)->first();
            if (!$question)
                return $this->notFoundMessage('did not found this question.');
            $favorite = Favorite::where('question_id', $question->id)->first();

            if (!$favorite)
                return $this->notFoundMessage();
            $favorite->delete();

            return $this->apiResponse(null, true, 'the question has been deleted from favorites');

        } catch (\Exception $ex) {
            return $this->internalServer($ex->getMessage());
        }

    }
}
