<?php

namespace App\Http\Middleware;

use App\Models\Specialization;
use Closure;
use Illuminate\Http\Request;
use App\traits\GeneralTrait;

class isPayed
{
    use GeneralTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(!auth('sanctum')->user())
            return $this->unAuthorisedResponse();

        $specialization=Specialization::where('uuid',$request->specialization_uuid)->first();
        if(!$specialization)
            return $this->notFoundMessage();

        if(auth('sanctum')->user()->role)
            return $next($request);

        if($specialization->id != auth('sanctum')->user()->specialization_id)
            return $this->apiResponse(null,false,'you should pay first wlaaaak ya nassab.',401);

        return $next($request);
    }
}
