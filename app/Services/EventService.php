<?php

namespace App\Services;

use App\Repositories\EventRepository;

class EventService
{
    private $eventRepository;

    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function paginate($paginationDataFromRequest)
    {
        $limit = $paginationDataFromRequest['limit'];
        $sortColumn = $paginationDataFromRequest['sort_column'];
        $sortType = $paginationDataFromRequest['sort_type'];
        $filterColumn = $paginationDataFromRequest['filter_column'];
        $filterData = $paginationDataFromRequest['filter_data'];
        $searchData = $paginationDataFromRequest['search_data'];

        return $this->eventRepository->paginate($limit, $sortColumn, $sortType, $filterColumn, $filterData, $searchData);
    }

    public function paginateEventIncoming($paginationDataFromRequest)
    {
        $limit = $paginationDataFromRequest['limit'];
        $sortColumn = $paginationDataFromRequest['sort_column'];
        $sortType = $paginationDataFromRequest['sort_type'];
        $filterColumn = $paginationDataFromRequest['filter_column'];
        $filterData = $paginationDataFromRequest['filter_data'];
        $searchData = $paginationDataFromRequest['search_data'];

        return $this->eventRepository->paginateEventIncoming($limit, $sortColumn, $sortType, $filterColumn, $filterData, $searchData);
    }

    public function paginateEventHappening($paginationDataFromRequest)
    {
        $limit = $paginationDataFromRequest['limit'];
        $sortColumn = $paginationDataFromRequest['sort_column'];
        $sortType = $paginationDataFromRequest['sort_type'];
        $filterColumn = $paginationDataFromRequest['filter_column'];
        $filterData = $paginationDataFromRequest['filter_data'];
        $searchData = $paginationDataFromRequest['search_data'];

        return $this->eventRepository->paginateEventHappening($limit, $sortColumn, $sortType, $filterColumn, $filterData, $searchData);
    }

    public function paginateEventOver($paginationDataFromRequest)
    {
        $limit = $paginationDataFromRequest['limit'];
        $sortColumn = $paginationDataFromRequest['sort_column'];
        $sortType = $paginationDataFromRequest['sort_type'];
        $filterColumn = $paginationDataFromRequest['filter_column'];
        $filterData = $paginationDataFromRequest['filter_data'];
        $searchData = $paginationDataFromRequest['search_data'];

        return $this->eventRepository->paginateEventOver($limit, $sortColumn, $sortType, $filterColumn, $filterData, $searchData);
    }

    public function getById($id)
    {
        return $this->eventRepository->findById($id);
    }

    public function create($data)
    {
        $data['type'] = config('constants.EVENT_TYPE.PARTY');
        $data['status'] = config('constants.EVENT_STATUS.INCOMING_EVENT');

        return $this->eventRepository->store($data);
    }

    public function getEventsParticipating($idUser)
    {
        return $this->eventRepository->getEventsParticipating($idUser);
    }

    public function getEventsJoined($idUser)
    {
        return $this->eventRepository->getEventsJoined($idUser);
    }

    public function getEventsInProgressAccept($idUser)
    {
        return $this->eventRepository->getEventsInProgressAccept($idUser);
    }
}
