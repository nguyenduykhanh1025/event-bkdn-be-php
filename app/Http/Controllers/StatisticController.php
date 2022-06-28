<?php

namespace App\Http\Controllers;

use App\DTOs\Journal\NewJournalDTO;
use App\DTOs\Pagination\PaginationDTO;
use App\DTOs\Pagination\PaginationResponseDTO;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use App\Services\EventService;
use App\Services\JournalService;
use App\Services\SendNotificationService;
use App\Services\UserService;

class StatisticController extends Controller
{
    private $journalService;
    private $sendNotificationService;
    private $eventService;
    private $userService;

    public function __construct(
        JournalService $journalService,
        SendNotificationService $sendNotificationService,
        EventService $eventService,
        UserService $userService
    ) {
        $this->journalService = $journalService;
        $this->sendNotificationService = $sendNotificationService;
        $this->eventService = $eventService;
        $this->userService = $userService;
    }

    public function getStatisticGeneral(Request $request)
    {
        try {
            return $this->responseSuccess([
                'count_event' => $this->eventService->getCount(),
                'count_participant' => $this->userService->getCountParticipant(),
                'count_journal' => $this->journalService->getCount(),
                'sum_point_number' => $this->eventService->getSumPointNumber()[0],
            ]);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
