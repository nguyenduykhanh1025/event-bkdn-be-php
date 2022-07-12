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

    public function findAllByIdEvent($idEvent)
    {
        return $this->model->where('id_event', $idEvent)->get();
    }

    public function findUsersExistInTimeEvent($startDate, $endDate, $idUser, $idEvent)
    {
        return DB::select(
            'SELECT * FROM event_users 
                INNER JOIN events 
                ON event_users.id_event = events.id 
                    WHERE event_users.id_user = ?
                    AND event_users.id_event <> ?
                    AND ((events.start_at 
                        BETWEEN ? 
                        AND ?
                        OR events.end_at
                        BETWEEN ? 
                        AND ?)
                        OR (
                            events.start_at > ?
                            AND events.end_at < ?
                        ))',
            [$idUser, $idEvent, $startDate, $endDate,  $startDate, $endDate, $startDate, $endDate]
        );
    }

    public function findSumPointNumberByIdUser($idUser)
    {
        return DB::select(
            'SELECT sum(point_number) FROM event_users
                LEFT JOIN events
                ON event_users.id_event = events.id
                    WHERE event_users.id_user = ?
            ',
            [$idUser]
        );
    }

    public function findAllByIdUser($idUser)
    {
        return $this->model->where('id_user', $idUser)->get();
    }
}
