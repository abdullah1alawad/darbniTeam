<?php

namespace App\Http\Controllers;

use App\Http\Resources\SpecializationResource;
use App\Models\Specialization;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;

class SpecializationController extends Controller
{
    use GeneralTrait;

    public function index()
    {
        $specializations=Specialization::all();
        $specializations=SpecializationResource::collection($specializations);
        return $this->apiResponse($specializations,true,'all specializations');
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show(Specialization $specialization)
    {
        //
    }


    public function edit(Specialization $specialization)
    {
        //
    }


    public function update(Request $request, Specialization $specialization)
    {
        //
    }


    public function destroy(Specialization $specialization)
    {
        //
    }
}
