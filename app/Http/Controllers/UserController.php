<?php

namespace App\Http\Controllers;

use App\DTOs\Pagination\PaginationDTO;
use App\DTOs\Pagination\PaginationResponseDTO;
use App\DTOs\User\ChangePasswordDTO;
use App\DTOs\User\UpdateUserDTO;
use Illuminate\Http\Request;
use App\Services\UserService;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function paginate(Request $request)
    {
        $validate = (new PaginationDTO())->validateRequest($request);
        if ($validate['is_error']) {
            return  $this->responseError($validate['data'], Response::HTTP_BAD_REQUEST);
        }

        $paginationDataFromRequest = $validate['data'];
        try {
            $paginateDataFromDB = $this->userService->paginate($paginationDataFromRequest);

            $result = (new PaginationResponseDTO())
                ->setItems($paginateDataFromDB->items())
                ->setMetaCurrentPage($paginateDataFromDB->currentPage())
                ->setMetaPerPage($paginateDataFromDB->perPage())
                ->setMetaTotal($paginateDataFromDB->total());

            return $this->responseSuccess($result->getResponse(), Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function disableUser(Request $request)
    {
        $userId = $request->get('userId');

        if (!$this->userService->getUserById($userId)) {
            return $this->responseError(config('constants.message.user.USER_DOES_NOT_EXIST'), Response::HTTP_LOCKED);
        }

        try {
            $this->userService->setActiveStatusById(False, $userId);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function enableUser(Request $request)
    {
        $userId = $request->get('userId');

        if (!$this->userService->getUserById($userId)) {
            return $this->responseError(config('constants.message.user.USER_DOES_NOT_EXIST'), Response::HTTP_LOCKED);
        }

        try {
            $this->userService->setActiveStatusById(True, $userId);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getUserById(Request $request)
    {
        $userId = $request->all()['id'];

        $userFromDB = $this->userService->getUserById($userId);
        if (!$userFromDB) {
            return $this->responseError(config('constants.message.user.USER_DOES_NOT_EXIST'), Response::HTTP_LOCKED);
        }
        return $this->responseSuccess($userFromDB);
    }

    public function updateUserById(Request $request)
    {
        $routeParameters = $request->route()->parameters();

        $validate = (new UpdateUserDTO())->validateRequest($request);
        if ($validate['is_error']) {
            return  $this->responseError($validate['data'], Response::HTTP_BAD_REQUEST);
        }

        $userId = $routeParameters['id'];
        if (!$this->userService->getUserById($userId)) {
            return $this->responseError(config('constants.message.user.USER_DOES_NOT_EXIST'), Response::HTTP_LOCKED);
        }

        try {
            $resFromDB = $this->userService->updateUserById($userId, $validate['data']);
            return $this->responseSuccess($resFromDB);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function paginateParticipant(Request $request)
    {
        $validate = (new PaginationDTO())->validateRequest($request);
        if ($validate['is_error']) {
            return  $this->responseError($validate['data'], Response::HTTP_BAD_REQUEST);
        }

        $paginationDataFromRequest = $validate['data'];
        try {
            $paginateDataFromDB = $this->userService->paginateParticipant($paginationDataFromRequest);

            $result = (new PaginationResponseDTO())
                ->setItems($paginateDataFromDB->items())
                ->setMetaCurrentPage($paginateDataFromDB->currentPage())
                ->setMetaPerPage($paginateDataFromDB->perPage())
                ->setMetaTotal($paginateDataFromDB->total());

            return $this->responseSuccess($result->getResponse(), Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getUsersByIdEventAndStatus(Request $request)
    {
        $status = $request->all()['status'];
        $idEvent = $request->all()['idEvent'];

        try {
            $resFromDB = $this->userService->getUsersByIdEventAndStatus($idEvent, $status);
            return $this->responseSuccess($resFromDB);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getUsersByIdEvent(Request $request)
    {
        $idEvent = $request->all()['idEvent'];

        try {
            $resFromDB = $this->userService->getUsersByIdEvent($idEvent);
            return $this->responseSuccess($resFromDB);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updatePassword(Request $request)
    {
        $validate = (new ChangePasswordDTO())->validateRequest($request);
        if ($validate['is_error']) {
            return  $this->responseError($validate['data'], Response::HTTP_BAD_REQUEST);
        }

        $dataFromRequest = $validate['data'];
        $userFromDB = $this->userService->getUserById($dataFromRequest['id']);
        if (!Hash::check($dataFromRequest['current_password'],  $userFromDB['password'])) {
            return  $this->responseError('current_pass_not_match', Response::HTTP_BAD_REQUEST);
        }

        $userNeedUpdate = null;
        $userNeedUpdate['id'] = $userFromDB['id'];
        $userNeedUpdate['password'] = Hash::make($dataFromRequest['new_password']);

        try {
            return $this->responseSuccess($this->userService->updateUserById($userFromDB['id'], $userNeedUpdate));
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
