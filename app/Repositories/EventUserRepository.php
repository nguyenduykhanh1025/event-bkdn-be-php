<?php

namespace App\Repositories;

use App\Models\EventUser;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class EventUserRepository extends BaseRepository
{

    public function __construct(EventUser $eventUser)
    {
        $this->model = $eventUser;
    }

    public function findByIdEventAndIdUser($idEvent, $idUser)
    {
        return $this->model->where('id_event', $idEvent)->where('id_user', $idUser)->get();
    }

    public function findUsersExistInTimeEvent($startDate, $endDate, $idUser, $idEvent)
    {
        // return $this->model->where('id_user', $idUser)->join('events', 'events.id', '=', 'event_users.id_event')
        //     ->whereDate([
        //         ['events.start_at', '>=', $startDate],
        //         ['events.start_at', '<=', $endDate]
        //     ])
        //     ->orWhere(function ($query, $startDate, $endDate) {
        //         $query->whereDate('events.end_at', '>=', $startDate)
        //             ->whereDate('events.end_at', '<=', $endDate);
        //     })
        //     ->get();
        // 'idUser' => $idUser.'', 'idEvent' => $idEvent.'', 'startDate' => $startDate . '', 'endDate' => $endDate . ''
        return DB::select(
            'SELECT * FROM event_users 
                INNER JOIN events 
                ON event_users.id_event = events.id 
                    WHERE event_users.id_user = ?
                    AND event_users.id_event <> ?
                    AND (events.start_at 
                        BETWEEN ? 
                        AND ?
                        OR events.end_at
                        BETWEEN ? 
                        AND ?)',
            [$idUser, $idEvent, $startDate, $endDate,  $startDate, $endDate]
        );
    }
}
