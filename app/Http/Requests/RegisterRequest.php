<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\GeneralTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;


class RegisterRequest extends FormRequest
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
     *'numeric
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'specialization_uuid' => ['required','exists:specializations,uuid'],
            'username' => ['required', 'regex:/^[a-zA-Z0-9](?!.*[._]{2})[a-zA-Z0-9._]{0,28}[a-zA-Z0-9]$/u', 'unique:users'],
            'phone' => ['required', 'regex:/^0[0-9]{9}$/']
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();

        $response = $this->apiResponse(null, false, $errors->all(), 422);

        throw new ValidationException($validator, $response);
    }

}











//        $response = $this->apiResponse($errors->has('specialization_uuid.numeric'), false, '', 422);




















//        if($errors->has('username.regex'))
//            $response=$this->apiResponse(null,false,'username can start or end alphanumeric character,
//            Can contain alphanumeric characters, periods (.), and underscores (_) in between,
//            Doesnt allow consecutive periods or underscores,
//            Has a maximum length of 30 characters (28 characters between the first and last character.',422);
//
//        else if ($errors->has('username.unique'))
//            $response = $this->apiResponse(null, false, 'User name already exist.', 422);
//
//        else
