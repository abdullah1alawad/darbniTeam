<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use App\traits\GeneralTrait;

class AddQuestionRequest extends FormRequest
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
            'subject_uuid' => ['required','exists:subjects,uuid'],
            'question' => ['required', 'regex:/^[\p{Arabic}a-zA-Z0-9\s.,!?-]*$/u', 'max:40'],
            'answers' => ['required', 'array'],
            'answers.*' => ['required', 'array'],
            'answers.*.*' => ['required', 'regex:/^[\p{Arabic}a-zA-Z0-9\s.,!?-]*$/u'],
            'reference' => ['required', 'string'],
            'mark' => ['required', 'numeric'],
            'is_book'=>['nullable','boolean'],
            'date'=>['nullable','date']
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();

        $response = $this->apiResponse(null, false, $errors->all(), 422);

        throw new ValidationException($validator, $response);
    }
}
