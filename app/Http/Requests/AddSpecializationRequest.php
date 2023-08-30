<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use App\traits\GeneralTrait;

class AddSpecializationRequest extends FormRequest
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
     */
    public function rules()
    {
        return [
            'name' => ['required', 'regex:/^[\p{Arabic}a-zA-Z0-9\s.,!?-]*$/u', 'max:40','unique:specializations'],
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
