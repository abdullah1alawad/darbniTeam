<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\Specialization;
use App\Models\User;
use App\traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;


class AuthController extends Controller
{
    use GeneralTrait;

    public function register(RegisterRequest $request)
    {
        try {
            $specialization = Specialization::where('uuid', $request->specialization_uuid)->first();

            $user = User::create([
                'username' => $request->username,
                'specialization_id' => $specialization->id,
                'phone' => $request->phone,
                'uuid' => Str::uuid(),
                'code' => Crypt::encrypt(Str::random(10)),
            ]);

            $user = UserResource::make($user);

            return $this->apiResponse($user, true, 'the user is registered successfully.');

        } catch (\Exception $ex) {
            return $this->internalServer($ex->getMessage());
        }
    }

    public function login(LoginRequest $request)
    {
        try {

            $user = User::where('username', $request->username)->first();

            $user->tokens()->delete();
            $token = $user->createToken('darbni')->plainTextToken;

            $user->token = $token;
            $user = UserResource::make($user);

            return $this->apiResponse($user, true, 'The user is logged in successfully.');
        } catch (\Exception $ex) {
            return $this->internalServer($ex->getMessage());
        }
    }

    public function logout(Request $request)
    {
        auth('sanctum')->user()->tokens()->delete();

        return $this->apiResponse(null, true, 'Logged out successfully');
    }
}
