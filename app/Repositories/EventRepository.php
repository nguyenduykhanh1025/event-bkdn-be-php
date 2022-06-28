<?php

namespace App\Repositories;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EventRepository extends BaseRepository
{

    public function __construct(Event $eventModel)
    {
        $this->model = $eventModel;
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

    public function paginateEventIncoming(
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
        $query->where('start_at', '>', Carbon::now());

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

    public function paginateEventOver(
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
        $query->where('end_at', '<', Carbon::now());

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

    public function paginateEventHappening(
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
        $query->where('start_at', '<=', Carbon::now());
        $query->where('end_at', '>=', Carbon::now());

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

    public function getEventsParticipating($idUser)
    {
        return $this->model->join('event_users', 'events.id', '=', 'event_users.id_event')
            ->where('event_users.id_user', $idUser)
            ->where('event_users.status', config('constants.EVENT_USER_STATUS.ACCEPTED'))
            ->where('events.end_at', '<=', Carbon::now())->get();
    }

    public function getEventsJoined($idUser)
    {
        return $this->model->join('event_users', 'events.id', '=', 'event_users.id_event')
            ->where('event_users.id_user', $idUser)
            ->where('event_users.status', config('constants.EVENT_USER_STATUS.ACCEPTED'))
            ->where('events.end_at', '>', Carbon::now())->get();
    }

    public function getEventsInProgressAccept($idUser)
    {
        return $this->model->join('event_users', 'events.id', '=', 'event_users.id_event')
            ->where('event_users.id_user', $idUser)
            ->where('event_users.status', config('constants.EVENT_USER_STATUS.IN_PROGRESS'))->get();
    }

    public function getEventsInComming()
    {
        return $this->model->select('events.*', 'event_users.id_user')->leftJoin('event_users', 'events.id', '=', 'event_users.id_event')
            ->where('events.start_at', '>', Carbon::now())->get();
    }

    public function getEventsJoin($idUser)
    {
        return $this->model->select('events.*', 'event_users.status as event_users_status')->join('event_users', 'events.id', '=', 'event_users.id_event')
            ->where('event_users.id_user', $idUser)->get();
    }

    public function getEventsNewNotExistUser($idUser)
    {
        return $this->model->select('events.*', 'event_users.status as event_users_status')->leftJoin('event_users', 'events.id', '=', 'event_users.id_event')
            ->where('event_users.id_user', '<>', $idUser)->orWhereNull('event_users.id_user')
            ->where('events.start_at', '>', Carbon::now())->get();
    }

    public function getCount()
    {
        return $this->model->count();
    }

    public function findSumPointNumber()
    {
        return DB::select(
            'SELECT sum(point_number) AS sum_point_number FROM events
            '
        );
    }
}
