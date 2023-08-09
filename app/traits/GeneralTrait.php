<?php

namespace App\Traits;

use Illuminate\Http\Response;
trait GeneralTrait
{
    public function apiResponse($data = null, $status = true, $error = null, $statusCode = 200) : Response
    {
        $array = [
            'data' => $data,
            'status' => $status,
            'error' => $error,
            'statusCode' => $statusCode
        ];
        return response($array);
    }

    public function unAuthorisedResponse(): Response
    {
        return $this->apiResponse(null, false, 'Unauthorised !!', 401);
    }

    public function notFoundMessage($more = null): Response
    {
        return $this->apiResponse(null, true, $more . ' Not found in our database !', 404);
    }

    public function requiredField($message): Response
    {
        return $this->apiResponse(null, false, $message, 200);
    }

    public function apiValidation($request, $array): array
    {
        foreach ($array as $field) {
            if (!$request->has($field))
                return [false, 'Field ' . $field . ' is required'];
            if ($request[$field] == null)
                return [false, "Field " . $field . " can't be empty"];
        }
        return [true, 'No error'];
    }

//    protected function successResponse($data, $message = null, $code = 200)
//    {
//        return response()->json([
//            'status'=> 'Success',
//            'message' => $message,
//            'data' => $data
//        ], $code);
//    }
//
//    protected function errorResponse($message = null, $code)
//    {
//        return response()->json([
//            'status'=>'Error',
//            'message' => $message,
//            'data' => null
//        ], $code);
//    }


}
