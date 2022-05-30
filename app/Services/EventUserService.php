<?php

namespace App\Services;

use App\Repositories\EventUserRepository;
use App\Repositories\UserRepository;

class EventUserService
{
    private $eventUserRepository;

    public function __construct(EventUserRepository $eventUserRepository)
    {
        $this->eventUserRepository = $eventUserRepository;
    }

    public function create($data)
    {
        return $this->eventUserRepository->store($data);
    }

    public function getByIdEventAndIdUser($idEvent, $idUser)
    {
        return $this->eventUserRepository->findByIdEventAndIdUser($idEvent, $idUser);
    }
}
