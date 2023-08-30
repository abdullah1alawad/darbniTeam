<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddSliderRequest;
use App\Http\Resources\SliderResource;
use App\Models\Slider;
use App\traits\GeneralTrait;
use Illuminate\Support\Str;

class SliderController extends Controller
{
    use GeneralTrait;

    public function index()
    {
        try {
            $sliders = Slider::all();
            $sliders = SliderResource::collection($sliders);

            return $this->apiResponse($sliders, true, 'all sliders here.');

        } catch (\Exception $ex) {
            return $this->internalServer($ex->getMessage());
        }
    }

    public function store(AddSliderRequest $request)
    {
        Slider::create([
            'uuid' => Str::uuid(),
            'content' => $request->input('content'),
        ]);

        return $this->apiResponse(null, true, 'the slider has been added successfully.');
    }
}
