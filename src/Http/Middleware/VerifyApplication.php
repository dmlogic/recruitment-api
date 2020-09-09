<?php

namespace Dmlogic\RecruitmentApi\Http\Middleware;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Route;
use Dmlogic\RecruitmentApi\Models\Application;
use Illuminate\Http\Exceptions\HttpResponseException;

class VerifyApplication
{
    public function handle($request, Closure $next)
    {
        if(!$application = $this->findApplicationFromToken($request)) {
            throw new HttpResponseException(
                response()->json(['errors' => ['The access token is invalid']], JsonResponse::HTTP_UNAUTHORIZED)
            );
        }
        $request->attributes->set('application',$application);
        return $next($request);
    }

    protected function findApplicationFromToken($request)
    {
        if(!$token = Str::after($request->header('Authorization'), 'Bearer ')) {
            return false;
        }
        return Application::where('token','=',$token)
                          ->where('uuid','=',Route::current()->parameter('uuid'))
                          ->first();
    }
}
