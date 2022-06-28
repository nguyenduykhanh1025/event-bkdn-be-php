<?php

namespace App\Services;

use App\Repositories\JournalRepository;
use Carbon\Carbon;

class JournalService
{
    private $journalRepository;

    public function __construct(JournalRepository $journalRepository)
    {
        $this->journalRepository = $journalRepository;
    }

    public function paginate($paginationDataFromRequest)
    {
        $limit = $paginationDataFromRequest['limit'];
        $sortColumn = $paginationDataFromRequest['sort_column'];
        $sortType = $paginationDataFromRequest['sort_type'];
        $filterColumn = $paginationDataFromRequest['filter_column'];
        $filterData = $paginationDataFromRequest['filter_data'];
        $searchData = $paginationDataFromRequest['search_data'];

        return $this->journalRepository->paginate($limit, $sortColumn, $sortType, $filterColumn, $filterData, $searchData);
    }

    public function create($data)
    {
        $data['posted_at'] = Carbon::now();
        return $this->journalRepository->store($data);
    }

    public function getById($id)
    {
        return $this->journalRepository->findById($id);
    }

    public function deleteById($id)
    {
        return $this->journalRepository->deleteById($id);
    }

    public function updateToIsActiveById($id, $isActive)
    {
        $dataFromDb['is_active'] = $isActive;
        $dataFromDb['id'] = $id;

        $this->journalRepository->update($id, $dataFromDb);
    }

    public function getCount()
    {
        return $this->journalRepository->getCount();
    }
}
