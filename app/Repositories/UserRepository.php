<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends BaseRepository
{

    public function __construct(User $userModel)
    {
        $this->model = $userModel;
    }

    public function findByEmail($email)
    {
        return $this->model::where('email', '=', $email)->first();
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
            $query->where('email', 'like', "%$searchData%");
        }

        if ($sortColumn && $sortType) {
            $query->orderBy($sortColumn, $sortType);
        }

        return $query->paginate($limit);
    }

    // public function findById($id)
    // {
    //     return $this->model->where('id', $id)->first();
    // }

    public function paginateParticipant(
        $limit,
        $sortColumn = 'id',
        $sortType = 'asc',
        $filterColumn = '',
        $filterData = '',
        $searchData = ''
    ) {
        $query = $this->model::query();
        $query = $this->model::role(config('constants.role.PARTICIPANT'));

        if ($filterColumn && $filterData) {
            $query->where($filterColumn, 'like', $filterData);
        }

        if ($searchData) {
            $query->where('email', 'like', "%$searchData%");
        }

        if ($sortColumn && $sortType) {
            $query->orderBy($sortColumn, $sortType);
        }

        return $query->paginate($limit);
    }

    public function getUserByIdEventEndStatusEvent($idEvent, $statusEvent)
    {
        return $this->model->join('event_users', 'users.id', '=', 'event_users.id_user')->where('event_users.status', $statusEvent)->where('event_users.id_event', $idEvent)->get();
    }

    public function getUserByIdEvent($idEvent)
    {
        return $this->model->join('event_users', 'users.id', '=', 'event_users.id_user')->where('event_users.id_event', $idEvent)->get();
    }

    public function getAllHaveExponentPushTokenNotNull()
    {
        return $this->model->whereNotNull('exponent_push_token')->get();
    }

    public function getCountParticipant()
    {
        return $this->model::role(config('constants.role.PARTICIPANT'))->count();
    }
}
