<?php

namespace App\Services;

use App\Repositories\JournalRepository;
use App\Repositories\ManagerEventRepository;
use Carbon\Carbon;

class ManagerEventService
{
    private $managerEventRepository;

    public function __construct(ManagerEventRepository $managerEventRepository)
    {
        $this->managerEventRepository = $managerEventRepository;
    }

    public function paginate($paginationDataFromRequest)
    {
        $limit = $paginationDataFromRequest['limit'];
        $sortColumn = $paginationDataFromRequest['sort_column'];
        $sortType = $paginationDataFromRequest['sort_type'];
        $filterColumn = $paginationDataFromRequest['filter_column'];
        $filterData = $paginationDataFromRequest['filter_data'];
        $searchData = $paginationDataFromRequest['search_data'];

        return $this->managerEventRepository->paginate($limit, $sortColumn, $sortType, $filterColumn, $filterData, $searchData);
    }

    public function create($data)
    {
        return $this->managerEventRepository->store($data);
    }

    public function all()
    {
        return $this->managerEventRepository->all();
    }

    public function getById($id)
    {
        return $this->managerEventRepository->findById($id);
    }
}
