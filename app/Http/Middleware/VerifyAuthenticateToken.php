<?php

namespace App\Http\Middleware;

use App\DTOs\Response\ResponseDTO;
use Closure;
use Illuminate\Http\Request;
use JWTAuth;

use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;

class VerifyAuthenticateToken
{
    public function handle(Request $request, Closure $next)
    {
        $errorMessage = null;

        try {
            if (!JWTAuth::parseToken()->authenticate()) {
                $errorMessage = config('constants.message.token.USER_NOT_FOUND_BY_GIVEN_TOKEN');
            }
        } catch (TokenExpiredException $e) {
            $errorMessage = config('constants.message.token.TOKEN_IS_EXPIRED');
        } catch (TokenInvalidException $e) {
            $errorMessage = config('constants.message.token.TOKEN_IS_INVALID');
        } catch (JWTException $e) {
            $errorMessage = config('constants.message.token.TOKEN_IS_REQUIRED');
        }

        if ($errorMessage) {
            return response(
                (new ResponseDTO())->setMessage($errorMessage)->getResponse(),
                Response::HTTP_FORBIDDEN
            );
        }

        return $next($request);
    }
}
