<?php

namespace App\Repositories;

use App\Models\EventUser;
use App\Models\User;

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
}
