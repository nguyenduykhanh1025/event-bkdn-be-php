<?php

namespace App\Http\Controllers;

use App\DTOs\Journal\NewJournalDTO;
use App\DTOs\ManagerEvent\NewManagerEventDTO;
use App\DTOs\Pagination\PaginationDTO;
use App\DTOs\Pagination\PaginationResponseDTO;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use App\Services\JournalService;
use App\Services\ManagerEventService;
use App\Services\SendNotificationService;

class ManagerEventController extends Controller
{
    private $journalService;
    private $sendNotificationService;
    private $managerEventService;

    public function __construct(
        JournalService $journalService,
        SendNotificationService $sendNotificationService,
        ManagerEventService $managerEventService
    ) {
        $this->journalService = $journalService;
        $this->sendNotificationService = $sendNotificationService;
        $this->managerEventService = $managerEventService;
    }

    public function paginate(Request $request)
    {
        $validate = (new PaginationDTO())->validateRequest($request);
        if ($validate['is_error']) {
            return  $this->responseError($validate['data'], Response::HTTP_BAD_REQUEST);
        }

        $paginationDataFromRequest = $validate['data'];
        try {
            $paginateDataFromDB = $this->managerEventService->paginate($paginationDataFromRequest);

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

    public function create(Request $request)
    {
        $validate = (new NewManagerEventDTO())->validateRequest($request);
        if ($validate['is_error']) {
            return  $this->responseError($validate['data'], Response::HTTP_BAD_REQUEST);
        }

        try {
            $res = $this->managerEventService->create($validate['data']);

            return $this->responseSuccess(
                $res,
                Response::HTTP_OK
            );
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function all(Request $request)
    {
        try {
            return $this->responseSuccess(
                $this->managerEventService->all(),
                Response::HTTP_OK
            );
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(Request $request)
    {
        $routeParameters = $request->route()->parameters();
        $id = $routeParameters['id'];
        try {
            $dataResponse = $this->managerEventService->getById($id);
            return $this->responseSuccess($dataResponse);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
