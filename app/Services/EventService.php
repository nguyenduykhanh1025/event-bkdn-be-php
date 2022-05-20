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

    public function getById($id)
    {
        return $this->eventRepository->findById($id);
    }
}
