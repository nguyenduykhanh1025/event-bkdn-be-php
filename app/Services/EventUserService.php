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

    public function getById($id)
    {
        return $this->eventUserRepository->findById($id);
    }

    public function create($data)
    {
        return $this->eventUserRepository->store($data);
    }

    public function getByIdEventAndIdUser($idEvent, $idUser)
    {
        return $this->eventUserRepository->findByIdEventAndIdUser($idEvent, $idUser);
    }

    public function getAllByIdEvent($idEvent)
    {
        return $this->eventUserRepository->findAllByIdEvent($idEvent);
    }

    public function acceptedUserJoinToEventById($id)
    {
        $payload = null;
        $payload['status'] = config('constants.EVENT_USER_STATUS.ACCEPTED');
        return $this->eventUserRepository->update($id, $payload);
    }

    public function rejectedUserJoinToEventById($id)
    {
        $payload = null;
        $payload['status'] = config('constants.EVENT_USER_STATUS.REJECTED');
        return $this->eventUserRepository->update($id, $payload);
    }

    public function getUsersExistInTimeEvent($startDate, $endDate, $idUser, $idEvent)
    {
        return $this->eventUserRepository->findUsersExistInTimeEvent($startDate, $endDate, $idUser, $idEvent);
    }

    public function removeById($id)
    {
        return $this->eventUserRepository->deleteById($id);
    }

    public function delete($id)
    {
        return $this->eventUserRepository->deleteById($id);
    }
}
