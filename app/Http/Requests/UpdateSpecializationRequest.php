<?php

namespace App\Http\Requests;

use App\Models\Specialization;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use App\traits\GeneralTrait;

class UpdateSpecializationRequest extends FormRequest
{
    use GeneralTrait;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     * @throws \Exception
     */
    public function rules()
    {
        $specialization = Specialization::where('uuid', $this->route('specialization_uuid'))->first();
        if (!$specialization) {
            throw new \Exception("Specialization not found");
        }

        return [
            'name' => ['required', 'regex:/^[\p{Arabic}a-zA-Z0-9\s.,!?-]*$/u', 'max:40',
                Rule::unique('specializations')->ignore($specialization->id)],
            'type' => ['required', 'boolean'],
            'specialization_photo' => ['required', 'image', 'max:2048', 'mimes:jpeg,png,jpg,svg'],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();

        $response = $this->apiResponse(null, false, $errors->all(), 422);

        throw new ValidationException($validator, $response);
    }

}
