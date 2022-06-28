<?php

namespace App\Repositories;

use App\Models\Journal;

class JournalRepository extends BaseRepository
{

    public function __construct(Journal $journalModel)
    {
        $this->model = $journalModel;
    }

    public function findBTitle($title)
    {
        return $this->model::where('title', '=', $title)->first();
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

        $query->where('is_active', '=', 1);

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

    public function getCount()
    {
        return $this->model->count();
    }
}
