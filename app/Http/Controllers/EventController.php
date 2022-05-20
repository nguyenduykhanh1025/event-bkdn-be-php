<?php

namespace App\Http\Controllers;

use App\DTOs\Pagination\PaginationDTO;
use App\DTOs\Pagination\PaginationResponseDTO;
use App\DTOs\User\UpdateUserDTO;
use Illuminate\Http\Request;
use App\Services\UserService;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use App\Services\EventService;

class EventController extends Controller
{
    private $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
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
}
