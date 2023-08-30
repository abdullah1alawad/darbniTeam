<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddSpecializationRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\UpdateSpecializationRequest;
use App\Http\Resources\SpecializationResource;
use App\Models\Specialization;
use App\traits\GeneralTrait;
use Illuminate\Support\Str;

class SpecializationController extends Controller
{
    use GeneralTrait;

    public function index()
    {
        $specializations = Specialization::all();
        $specializations = SpecializationResource::collection($specializations);

        return $this->apiResponse($specializations, true, 'all specializations');
    }

    public function store(AddSpecializationRequest $request)
    {
        try {
            $photo = $request->file('specialization_photo');
            $specialization_photo = addPhoto($photo, 'specilizations_photos');

            $specialization = Specialization::create([
                'uuid' => Str::uuid(),
                'name' => $request->name,
                'type' => $request->type,
                'photo' => 'specializations_photos/' . $specialization_photo,
            ]);
            $specialization = SpecializationResource::make($specialization);

            return $this->apiResponse($specialization, true, 'the specialization has been added successfully');

        } catch (\Exception $ex) {
            return $this->internalServer($ex->getMessage());
        }
    }

    public function show(SearchRequest $request)
    {
        $specializations = Specialization::where('name', 'LIKE', '%' . $request->specialization_name . '%')->get();

        $specializations = SpecializationResource::collection($specializations);

        return $this->apiResponse($specializations, true, 'the search result');
    }

    public function update(UpdateSpecializationRequest $request, $specialization_uuid)
    {
        try {
            $specialization = Specialization::where('uuid', $specialization_uuid)->first();

            $specialization->name = $request->name;
            $specialization->type = $request->type;
            $specialization->photo = 'specializations_photos/' . addPhoto($request->file('specialization_photo'), 'specializations_photos');
            $specialization->save();

            $specialization = SpecializationResource::make($specialization);

            return $this->apiResponse($specialization, true, 'the specialization has been updated successfully.');

        } catch (\Exception $ex) {
            return $this->internalServer($ex->getMessage());
        }
    }

    public function destroy($specialization_uuid)
    {
        try {
            $specialization = Specialization::where('uuid', $specialization_uuid)->first();

            if (!$specialization)
                return $this->notFoundMessage();

            $specialization->delete();

            return $this->apiResponse(null, true, 'the specialization has been deleted successfully.');

        } catch (\Exception $ex) {
            return $this->internalServer($ex->getMessage());
        }
    }

}
