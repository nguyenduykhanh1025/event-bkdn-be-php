<?php

namespace App\Http\Controllers;

use App\DTOs\Auth\AuthLoginWithEmailAndPasswordDTO;
use App\DTOs\Auth\NewAdminDTO;
use App\DTOs\Auth\NewParticipantDTO;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use App\Services\AuthService;
use App\Services\SendNotificationService;

class AuthController extends Controller
{
    private $authService;
    private $sendNotificationService;

    public function __construct(AuthService $authService, SendNotificationService $sendNotificationService)
    {
        $this->authService = $authService;
        $this->sendNotificationService = $sendNotificationService;
    }

    public function registerAdminAccount(Request $request)
    {
        $validate = (new NewAdminDTO())->validateRequest($request);
        if ($validate['is_error']) {
            return  $this->responseError($validate['data'], Response::HTTP_BAD_REQUEST);
        }

        $userCreated = $this->authService->createAdminAccountFromRequestData($request->all());
        if ($userCreated == null) {
            return $this->responseError(config('constants.message.auth.CREATED_USER_FAILED'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return $this->responseSuccess($userCreated, Response::HTTP_CREATED);
    }

    public function registerParticipantAccount(Request $request)
    {
        $validate = (new NewParticipantDTO())->validateRequest($request);
        if ($validate['is_error']) {
            return  $this->responseError($validate['data'], Response::HTTP_BAD_REQUEST);
        }

        $userCreated = $this->authService->createParticipantFromRequestData($request->all());
        if ($userCreated == null) {
            return $this->responseError(config('constants.message.auth.CREATED_USER_FAILED'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->responseSuccess($userCreated, Response::HTTP_CREATED);
    }

    public function login(Request $request)
    {
        $validate = (new AuthLoginWithEmailAndPasswordDTO())->validateRequest($request);
        if ($validate['is_error']) {
            return  $this->responseError($validate['data'], Response::HTTP_BAD_REQUEST);
        }

        $token = null;
        $token = auth()->attempt($request->all());

        if (!$token) {
            return $this->responseError(
                config('constants.message.auth.UNAUTHORIZED'),
                Response::HTTP_FORBIDDEN
            );
        }
        return $this->responseSuccess(
            $this->createNewToken($token),
            Response::HTTP_OK
        );
    }

    protected function createNewToken($token)
    {
        return [
            'access_token' => $token,
        ];
    }
}
