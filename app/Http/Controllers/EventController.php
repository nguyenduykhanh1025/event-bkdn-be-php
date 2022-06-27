<?php

namespace App\Http\Controllers;

use App\DTOs\Event\NewEventDTO;
use App\DTOs\Event\UpdateEventDTO;
use App\DTOs\Pagination\PaginationDTO;
use App\DTOs\Pagination\PaginationResponseDTO;
use App\DTOs\User\UpdateUserDTO;
use Illuminate\Http\Request;
use App\Services\UserService;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use App\Services\EventService;
use App\Services\SendNotificationService;

class EventController extends Controller
{
    private $eventService;
    private $sendNotificationService;

    public function __construct(EventService $eventService, SendNotificationService $sendNotificationService)
    {
        $this->eventService = $eventService;
        $this->sendNotificationService = $sendNotificationService;
    }

    public function paginate(Request $request)
    {
        $validate = (new PaginationDTO())->validateRequest($request);
        if ($validate['is_error']) {
            return  $this->responseError($validate['data'], Response::HTTP_BAD_REQUEST);
        }

        $paginationDataFromRequest = $validate['data'];
        try {
            $paginateDataFromDB = $this->eventService->paginate($paginationDataFromRequest);

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



    public function paginateEventIncoming(Request $request)
    {
        $validate = (new PaginationDTO())->validateRequest($request);
        if ($validate['is_error']) {
            return  $this->responseError($validate['data'], Response::HTTP_BAD_REQUEST);
        }

        $paginationDataFromRequest = $validate['data'];
        try {
            $paginateDataFromDB = $this->eventService->paginateEventIncoming($paginationDataFromRequest);

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

    public function paginateEventHappening(Request $request)
    {
        $validate = (new PaginationDTO())->validateRequest($request);
        if ($validate['is_error']) {
            return  $this->responseError($validate['data'], Response::HTTP_BAD_REQUEST);
        }

        $paginationDataFromRequest = $validate['data'];
        try {
            $paginateDataFromDB = $this->eventService->paginateEventHappening($paginationDataFromRequest);

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

    public function paginateEventOver(Request $request)
    {
        $validate = (new PaginationDTO())->validateRequest($request);
        if ($validate['is_error']) {
            return  $this->responseError($validate['data'], Response::HTTP_BAD_REQUEST);
        }

        $paginationDataFromRequest = $validate['data'];
        try {
            $paginateDataFromDB = $this->eventService->paginateEventOver($paginationDataFromRequest);

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

    public function show(Request $request)
    {
        $routeParameters = $request->route()->parameters();
        $eventId = $routeParameters['id'];
        try {
            $dataResponse = $this->eventService->getById($eventId);
            return $this->responseSuccess($dataResponse);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getEventsParticipating(Request $request)
    {
        $idUser = auth()->user()['id'];
        try {
            $dataResponse = $this->eventService->getEventsParticipating($idUser);
            return $this->responseSuccess($dataResponse);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getEventsJoined(Request $request)
    {
        $idUser = auth()->user()['id'];
        try {
            $dataResponse = $this->eventService->getEventsJoined($idUser);
            return $this->responseSuccess($dataResponse);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getEventsInProgressAccept(Request $request)
    {
        $idUser = auth()->user()['id'];
        try {
            $dataResponse = $this->eventService->getEventsInProgressAccept($idUser);
            return $this->responseSuccess($dataResponse);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getEventsInComming(Request $request)
    {
        $idUser = auth()->user()['id'];
        try {
            $dataResponse = $this->eventService->getEventsInComming($idUser);
            return $this->responseSuccess($dataResponse);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function create(Request $request)
    {
        $validate = (new NewEventDTO())->validateRequest($request);
        if ($validate['is_error']) {
            return  $this->responseError($validate['data'], Response::HTTP_BAD_REQUEST);
        }

        try {
            $res = $this->eventService->create($validate['data']);
            $this->sendNotificationService->sendNotifyCationForAllParticipant(
                'Thông báo sự kiện mới sắp diễn ra',
                substr($validate['data']['description'], 0, 40),
            );
            return $this->responseSuccess(
                $res,
                Response::HTTP_OK
            );
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(Request $request)
    {
        $validate = (new UpdateEventDTO())->validateRequest($request);
        if ($validate['is_error']) {
            return  $this->responseError($validate['data'], Response::HTTP_BAD_REQUEST);
        }

        try {
            return $this->responseSuccess(
                $this->eventService->update($validate['data']),
                Response::HTTP_OK
            );
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getEventsJoin(Request $request)
    {
        $idUser = auth()->user()['id'];
        try {
            $dataResponse = $this->eventService->getEventsJoin($idUser);
            return $this->responseSuccess($dataResponse);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getEventsNewNotExistUser(Request $request)
    {
        $idUser = auth()->user()['id'];
        try {
            $dataResponse = $this->eventService->getEventsNewNotExistUser($idUser);
            return $this->responseSuccess($dataResponse);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getEventsJoinByIdUser(Request $request)
    {
        $idUser = $request->all()['id_user'];

        try {
            $dataResponse = $this->eventService->getEventsJoin($idUser);
            return $this->responseSuccess($dataResponse);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
