<?php

namespace App\Repositories;

use App\Models\Journal;
use App\Models\ManagerEvent;

class ManagerEventRepository extends BaseRepository
{

    public function __construct(ManagerEvent $managerEventModel)
    {
        $this->model = $managerEventModel;
    }

    public function paginate(
        $limit,
        $sortColumn = 'id',
        $sortType = 'asc',
        $filterColumn = '',
        $filterData = '',
        $searchData = ''
    ) {
        $query = $this->model::query();
        if ($filterColumn == 'role') {
            $query = $this->model::role($filterData);
        } else if ($filterColumn && $filterData) {
            $query->where($filterColumn, 'like', $filterData);
        }

        if ($searchData) {
            // $query->where('email', 'like', "%$searchData%");
        }

        if ($sortColumn && $sortType) {
            $query->orderBy($sortColumn, $sortType);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        return $query->paginate($limit);
    }
}
