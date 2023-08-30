<?php

namespace App\Http\Controllers;

use App\Http\Requests\PhotoRequest;
use App\Http\Requests\UserUpdateRequest;
use App\traits\GeneralTrait;

class UserController extends Controller
{
    use GeneralTrait;

    public function uploadPhoto(PhotoRequest $request)
    {
        try {
            $user = auth('sanctum')->user();

            $fileName = addPhoto($request->file('user_photo'),'users_photos');

            $user->photo = $fileName;
            $user->save();

            if (!$user->photo)
                return $this->apiResponse(null, false, 'some thing went wrong.', 500);

            return $this->apiResponse(null, true, 'the photo uploaded successfully');

        } catch (\Exception $ex) {
            return $this->internalServer($ex->getMessage());
        }
    }

    public function update(UserUpdateRequest $request)
    {
        try {
            $user = auth('sanctum')->user();

            $user->username = $request->username;
            $user->phone = $request->phone;
            $user->save();

            return $this->apiResponse(null, true, 'user information updated successfully.');

        } catch (\Exception $ex) {
            return $this->internalServer($ex->getMessage());
        }
    }

}
