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

    public function update($data)
    {
        $data['type'] = config('constants.EVENT_TYPE.PARTY');
        $data['status'] = config('constants.EVENT_STATUS.INCOMING_EVENT');

        return $this->eventRepository->update($data['id'], $data);
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

    public function getEventsInComming($idUser)
    {
        return $this->eventRepository->getEventsInComming($idUser);
    }

    public function getEventsJoin($idUser)
    {
        return $this->eventRepository->getEventsJoin($idUser);
    }

    public function getEventsNewNotExistUser($idUser)
    {
        return $this->eventRepository->getEventsNewNotExistUser($idUser);
    }

    public function addCountRegisteredByIdEvent($idEvent)
    {
        $eventFromDB = $this->eventRepository->findById($idEvent);
        $countRegistered = 0;
        if (empty($eventFromDB['count_registered'])) {
            $eventFromDB['count_registered'] = 0;
        }
        $countRegistered = $eventFromDB['count_registered'] + 1;

        $payload['id'] = $idEvent;
        $payload['count_registered'] = $countRegistered;

        $this->eventRepository->update($idEvent, $payload);
    }

    public function addCountParticipatedByIdEvent($idEvent)
    {
        $eventFromDB = $this->eventRepository->findById($idEvent);
        $countRegistered = 0;
        if (empty($eventFromDB['count_participated'])) {
            $eventFromDB['count_participated'] = 0;
        }
        $countRegistered = $eventFromDB['count_participated'] + 1;

        $payload['id'] = $idEvent;
        $payload['count_participated'] = $countRegistered;

        $this->eventRepository->update($idEvent, $payload);
    }

    public function getCount()
    {
        return $this->eventRepository->getCount();
    }

    public function getSumPointNumber()
    {
        return $this->eventRepository->findSumPointNumber();
    }

    public function delete($id)
    {
        return $this->eventRepository->deleteById($id);
    }
}
