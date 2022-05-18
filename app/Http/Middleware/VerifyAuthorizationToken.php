<?php

namespace App\Http\Middleware;

use App\DTOs\Response\ResponseDTO;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use JWTAuth;

class VerifyAuthorizationToken
{
    public function handle(Request $request, Closure $next)
    {
        $urlCurrent = url()->current();
        $roleFromUrl = $this->getRoleFromUrl($urlCurrent);
        if (!JWTAuth::user()->hasRole($roleFromUrl)) {
            $errorMessage = config('constants.message.auth.UNAUTHORIZED');
            return response(
                (new ResponseDTO())->setMessage($errorMessage)->getResponse(),
                Response::HTTP_UNAUTHORIZED
            );
        }

        return $next($request);
    }

    private function getRoleFromUrl($url)
    {
        $arrUrlWhenSplitApi = explode("api", $url);
        $roleKeyFromUrl = strtoupper(explode("/", $arrUrlWhenSplitApi[1])[1]);
        return config('constants.role.' . $roleKeyFromUrl);
    }
}
