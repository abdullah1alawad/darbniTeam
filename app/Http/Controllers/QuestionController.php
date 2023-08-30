<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddQuestionRequest;
use App\Http\Requests\AnswerRequest;
use App\Http\Requests\SubjectQuestionRequest;
use App\Http\Resources\QuestionResource;
use App\Models\Question;
use App\Models\Subject;
use Carbon\Carbon;
use App\traits\GeneralTrait;
use Illuminate\Support\Str;

class QuestionController extends Controller
{
    use GeneralTrait;

    public function store(AddQuestionRequest $request)
    {
        $subject = Subject::where('uuid', $request->subject_uuid)->first();

        $answers = [];
        foreach ($request->answers as $answer) {

            $answers[] = [
                'answer_uuid' => Str::uuid(),
                'answer' => $answer[0],
                'state' => (boolean)$answer[1],
            ];
        }

        $questionWithAnswers = [
            'question' => $request->question,
            'answers' => $answers,
        ];

        $question = Question::create([
            'uuid' => Str::uuid(),
            'subject_id' => $subject->id,
            'question' => $questionWithAnswers,
            'reference' => $request->reference,
            'mark' => $request->mark,
            'is_book' => $request->is_book,
            'date' => $request->date,
        ]);

        $question = QuestionResource::make($question);

        return $this->apiResponse($question, true, 'the question has been added successfully.');

    }

    public function bookQuestions(SubjectQuestionRequest $request, $level)
    {
        try {
            if (!$request->subject_uuids)
                return $this->apiResponse(null, false, 'you should choose a subjects.', 421);

            $subjects_ids = Subject::whereIn('uuid', $request->subject_uuids)->select('id')->get();

            $queryQuestions = Question::where('is_book', 1)
                ->whereIn('subject_id', $subjects_ids)
                ->whereHas('subject', function ($q) use ($level) {
                    $q->where('level', $level);
                })
                ->inRandomOrder()
                ->limit(50)
                ->get();

            $questions = QuestionResource::collection($queryQuestions);

            return $this->apiResponse($questions, true,
                '25 or less questions with answers and the correct and wrong answer.');

        } catch (\Exception $ex) {
            return $this->internalServer($ex->getMessage());
        }
    }

    public function getLastExams(SubjectQuestionRequest $request, $level)
    {
        try {
            $specialization_id = auth('sanctum')->user()->specialization_id;

            $subjects_ids = $request->subject_uuids;

            if ($request->subject_uuids)
                $subjects_ids = Subject::whereIn('uuid', $request->subject_uuids)->select('id')->get();

            if ($subjects_ids)
                $distinctDates = Question::whereIn('subject_id', $subjects_ids)
                    ->select('date')->distinct()->latest('date')->limit(5)->get();
            else
                $distinctDates = Question::whereHas('subject', function ($q) use ($level, $specialization_id) {
                    $q->where('specialization_id', $specialization_id);
                    $q->where('level', $level);
                })->select('date')->distinct()->latest('date')->limit(5)->get();

            $dateWithUuid = [];

            foreach ($distinctDates as $date) {
                $uuid = Question::select('uuid')->where('date', $date->date)->first();
                $carbonDate = Carbon::parse($date->date);

                $dateWithUuid[] = [
                    'date' => exams_date($carbonDate->month, $carbonDate->year),
                    'uuid' => $uuid->uuid,
                ];

            }
            if (!count($dateWithUuid))
                return $this->notFoundMessage('there is no exams contain this subject(s).');

            return $this->apiResponse($dateWithUuid, true, 'last 5 exams are here');

        } catch (\Exception $ex) {
            return $this->internalServer($ex->getMessage());
        }
    }

    public function examQuestions($question_uuid, $level)
    {
        try {
            $specialization_id = auth('sanctum')->user()->specialization_id;

            $exam_date = Question::where('uuid', $question_uuid)->select('date')->first();

            if (!$exam_date)
                return $this->notFoundMessage('not found the uuid in database');

            $queryQuestions = Question::with('subject')
                ->where('date', $exam_date->date)
                ->whereHas('subject', function ($q) use ($level, $specialization_id) {
                    $q->where('specialization_id', $specialization_id);
                    $q->where('level', $level);
                })
                ->inRandomOrder()
                ->get();

            $questions = QuestionResource::collection($queryQuestions);

            return $this->apiResponse($questions, true,
                'here is the exam questions with answers and the correct and wrong answer.');

        } catch (\Exception $ex) {
            return $this->internalServer($ex->getMessage());
        }
    }

    public function bankQuestions($level)
    {
        try {
            if (!auth('sanctum')->user())
                return $this->unAuthorisedResponse();
            $specialization_id = auth('sanctum')->user()->specialization_id;

            $queryQuestions = Question::whereHas('subject', function ($q) use ($level, $specialization_id) {
                $q->where('specialization_id', $specialization_id);
                $q->where('level', $level);
            })->inRandomOrder()->limit(50)->get();

            $questions = QuestionResource::collection($queryQuestions);

            return $this->apiResponse($questions, true, '50 questions or less are here');

        } catch (\Exception $ex) {
            return $this->internalServer($ex->getMessage());
        }
    }

    public function testQuestions(AnswerRequest $request)
    {
        $data = $request->all();
        $wrongCounter = 0;
        $mark = 0;
        $sum = 0;
        $correctAnswers = [];
        $questions = [];
        $allQuestionsCounter = count($data);

        foreach ($data as $val) {
            $question = Question::where('uuid', $val['question_uuid'])->first();

            $correct = null;

            foreach ($question->question['answers'] as $item) {
                if ($item['state']) {
                    $correct = $item['answer_uuid'];
                    break;
                }
            }

            $sum = $sum + $question->mark;

            if ($correct !== $val['answer_uuid']) {
                $wrongCounter++;
                $questions[]=QuestionResource::make($question);
                $correctAnswers[] = [
                    'question_uuid' => $question->uuid,
                    'correctAnswerUuid' => $correct,
                    'incorrectAnswerUuid' => $val['answer_uuid'],
                    'question_mark' => $question->mark,
                ];
            } else
                $mark = $mark + $question->mark;
        }

        $result = [
            'correct' => $allQuestionsCounter - $wrongCounter,
            'wrong' => $wrongCounter,
            'questions'=>$questions,
            'answers' => $correctAnswers,
            'student_mark' => $mark,
            'final_mark' => $sum,
        ];

        return $this->apiResponse($result, true, 'number of correct and wrong answers and the question_uuid that the user choose wrong and the correct answer');
    }

    public function destroy($question_uuid)
    {
        try {
            $question = Question::where('uuid', $question_uuid)->first();
            if (!$question)
                return $this->notFoundMessage();

            $question->delete();

            return $this->apiResponse(null, true, 'the question has been deleted successfully.');

        } catch (\Exception $ex) {
            return $this->internalServer($ex->getMessage());
        }
    }

}
