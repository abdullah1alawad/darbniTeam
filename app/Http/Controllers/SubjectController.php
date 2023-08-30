<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddSubjectRequest;
use App\Http\Resources\SubjectResource;
use App\Models\Specialization;
use App\Models\Subject;
use App\traits\GeneralTrait;
use Illuminate\Support\Str;

class SubjectController extends Controller
{
    use GeneralTrait;

    public function store(AddSubjectRequest $request)
    {
        try {
            $specialization = Specialization::where('uuid', $request->specialization_uuid)->first();
            $subject = Subject::create([
                'uuid' => Str::uuid(),
                'specialization_id' => $specialization->id,
                'name' => $request->name,
                'level' => $request->level,
            ]);

            $subject = SubjectResource::make($subject);

            return $this->apiResponse($subject, true, 'the subject has been added successfully.');

        } catch (\Exception $ex) {
            return $this->internalServer($ex->getMessage());
        }
    }


    public function show($specialization_uuid, $level)
    {
        try {
            $specialization = Specialization::where('uuid', $specialization_uuid)->first();
            if (!$specialization)
                return $this->apiResponse(null, false, 'didnt found this specialization.', 422);

            $subjects = Subject::where('specialization_id', $specialization->id)->where('level', $level)->get();
            $subjects = SubjectResource::collection($subjects);

            return $this->apiResponse($subjects, true, 'all subjects for this specialization.');

        } catch (\Exception $ex) {
            return $this->internalServer($ex->getMessage());
        }


    }

    public function update(AddSubjectRequest $request, $subject_uuid)
    {
        try {
            $subject = Subject::where('uuid', $subject_uuid)->first();
            $specialization = Specialization::where('uuid', $request->specialization_uuid)->first();

            $subject->specialization_id = $specialization->id;
            $subject->name = $request->name;
            $subject->level = $request->level;
            $subject->save();

            $subject = SubjectResource::make($subject);

            return $this->apiResponse($subject, true, 'the subject has been updated successfully.');

        } catch (\Exception $ex) {
            return $this->internalServer($ex->getMessage());
        }

    }


    public function destroy($subject_uuid)
    {
        try {
            $subject = Subject::where('uuid', $subject_uuid)->first();
            if (!$subject)
                return $this->notFoundMessage();

            $subject->delete();

            return $this->apiResponse(null, true, 'the subject has been deleted successfully.');

        } catch (\Exception $ex) {
            return $this->internalServer($ex->getMessage());
        }
    }
}
