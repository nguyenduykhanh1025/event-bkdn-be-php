<?php

namespace App\Http\Controllers;

use App\DTOs\Journal\NewJournalDTO;
use App\DTOs\Pagination\PaginationDTO;
use App\DTOs\Pagination\PaginationResponseDTO;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use App\Services\JournalService;
use App\Services\SendNotificationService;

class JournalController extends Controller
{
    private $journalService;
    private $sendNotificationService;


    public function __construct(JournalService $journalService, SendNotificationService $sendNotificationService)
    {
        $this->journalService = $journalService;
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
            $paginateDataFromDB = $this->journalService->paginate($paginationDataFromRequest);

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
        $validate = (new NewJournalDTO())->validateRequest($request);
        if ($validate['is_error']) {
            return  $this->responseError($validate['data'], Response::HTTP_BAD_REQUEST);
        }

        try {
            $res = $this->journalService->create($validate['data']);
            $this->sendNotificationService->sendNotifyCationForAllParticipant(
                'Thông báo tin tức mới',
                substr($validate['data']['title'], 0, 40),
            );

            return $this->responseSuccess(
                $res,
                Response::HTTP_OK
            );
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(Request $request)
    {
        $routeParameters = $request->route()->parameters();
        $journalId = $routeParameters['id'];
        try {
            $dataResponse = $this->journalService->getById($journalId);
            return $this->responseSuccess($dataResponse);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function delete(Request $request)
    {
        $routeParameters = $request->route()->parameters();
        $journalId = $routeParameters['id'];
        try {
            $dataResponse = $this->journalService->updateToIsActiveById($journalId, false);

            return $this->responseSuccess($dataResponse);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
