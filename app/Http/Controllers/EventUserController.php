<?php

namespace App\Http\Controllers;

use App\DTOs\EventUser\JoinToEventDTO;
use App\DTOs\EventUser\AcceptedUserJoinToEventDTO;
use App\DTOs\EventUser\RemoveToEventDTO;
use App\DTOs\Pagination\PaginationDTO;
use App\DTOs\Pagination\PaginationResponseDTO;
use App\DTOs\User\UpdateUserDTO;
use Illuminate\Http\Request;
use App\Services\UserService;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use App\Services\EventService;
use App\Services\EventUserService;

class EventUserController extends Controller
{
    private $eventUserService;
    private $userService;
    private $eventService;

    public function __construct(EventUserService $eventUserService, UserService $userService, EventService $eventService)
    {
        $this->eventUserService = $eventUserService;
        $this->userService = $userService;
        $this->eventService = $eventService;
    }

    public function joinToEvent(Request $request)
    {
        $validate = (new JoinToEventDTO())->validateRequest($request);
        if ($validate['is_error']) {
            return  $this->responseError($validate['data'], Response::HTTP_BAD_REQUEST);
        }
        $payload = $validate['data'];
        $userFromDB =  $this->userService->getByEmail($payload['email']);
        if (empty($userFromDB)) {
            return $this->responseError('user_does_not_exist', Response::HTTP_BAD_REQUEST);
        }

        $eventFromDB = $this->eventService->getById($payload['id_event']);
        $usersExistInTimeEvent = $this->eventUserService->getUsersExistInTimeEvent($eventFromDB['start_at'], $eventFromDB['end_at'],  $userFromDB['id'], $payload['id_event']);
        if (count($usersExistInTimeEvent) != 0) {
            return $this->responseError('exist_event_in_time', Response::HTTP_BAD_REQUEST);
        }

        $eventUserIsExist = $this->eventUserService->getByIdEventAndIdUser($payload['id_event'], $userFromDB['id']);
        if (count($eventUserIsExist) != 0) {
            return $this->responseError('user_joined', Response::HTTP_BAD_REQUEST);
        }

        $dataNeedCreate['id_user'] = $userFromDB['id'];
        $dataNeedCreate['id_event'] = $payload['id_event'];
        $dataNeedCreate['status'] = config('constants.EVENT_USER_STATUS.IN_PROGRESS');

        try {
            return $this->responseSuccess($this->eventUserService->create($dataNeedCreate), Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function removeToEvent(Request $request)
    {
        $validate = (new RemoveToEventDTO())->validateRequest($request);
        if ($validate['is_error']) {
            return  $this->responseError($validate['data'], Response::HTTP_BAD_REQUEST);
        }
        $idUser = auth()->user()['id'];
        $payload = $validate['data'];
        $eventUsersFromDB =  $this->eventUserService->getByIdEventAndIdUser($payload['id_event'], $idUser);
        if (!count($eventUsersFromDB)) {
            return;
        }
        echo $eventUsersFromDB[0]['id'];
        try {
            return $this->responseSuccess($this->eventUserService->removeById($eventUsersFromDB[0]['id']), Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    public function acceptedUserJoinToEvent(Request $request)
    {
        $validate = (new AcceptedUserJoinToEventDTO())->validateRequest($request);
        if ($validate['is_error']) {
            return  $this->responseError($validate['data'], Response::HTTP_BAD_REQUEST);
        }

        $id = $validate['data'];
        try {
            return $this->responseSuccess($this->eventUserService->acceptedUserJoinToEventById($id), Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function rejectedUserJoinToEvent(Request $request)
    {
        $validate = (new AcceptedUserJoinToEventDTO())->validateRequest($request);
        if ($validate['is_error']) {
            return  $this->responseError($validate['data'], Response::HTTP_BAD_REQUEST);
        }

        $id = $validate['data'];
        try {
            return $this->responseSuccess($this->eventUserService->rejectedUserJoinToEventById($id), Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
