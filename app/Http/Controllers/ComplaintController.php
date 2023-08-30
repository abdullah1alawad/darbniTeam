<?php

namespace App\Http\Controllers;

use App\Events\NewComplaintEvent;
use App\Http\Requests\ComplaintRequest;
use App\Models\Complaint;
use Illuminate\Support\Str;
use App\traits\GeneralTrait;

class ComplaintController extends Controller
{
    use GeneralTrait;

    public function store(ComplaintRequest $request)
    {
        try {

            if (!auth('sanctum')->user())
                return $this->unAuthorisedResponse();
            $user_id = auth('sanctum')->user()->id;

            $complaint = Complaint::create([
                'uuid' => Str::uuid(),
                'user_id' => $user_id,
                'content' => $request->input('content'),
            ]);

            event(new NewComplaintEvent($complaint));

            return $this->apiResponse(null, true, 'the complaint has been added successfully');

        } catch (\Exception $ex) {
            return $this->internalServer($ex->getMessage());
        }


    }
}
