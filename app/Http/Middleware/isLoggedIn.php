<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\traits\GeneralTrait;

class isLoggedIn
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

        return $next($request);
    }
}
