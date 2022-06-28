<?php

namespace App\Services;

use App\Repositories\EventUserRepository;
use App\Repositories\UserRepository;

class UserService
{
    private $userRepository;
    private $eventUserRepository;

    public function __construct(UserRepository $userRepository, EventUserRepository $eventUserRepository)
    {
        $this->userRepository = $userRepository;
        $this->eventUserRepository = $eventUserRepository;
    }

    public function paginate($paginationDataFromRequest)
    {
        $limit = $paginationDataFromRequest['limit'];
        $sortColumn = $paginationDataFromRequest['sort_column'];
        $sortType = $paginationDataFromRequest['sort_type'];
        $filterColumn = $paginationDataFromRequest['filter_column'];
        $filterData = $paginationDataFromRequest['filter_data'];
        $searchData = $paginationDataFromRequest['search_data'];

        return $this->userRepository->paginate($limit, $sortColumn, $sortType, $filterColumn, $filterData, $searchData);
    }

    public function setActiveStatusById($isActive, $userId)
    {
        $payload = [
            'is_active' => $isActive,
            'id' => $userId
        ];

        return $this->userRepository->update($userId, $payload);
    }

    public function getUserById($id)
    {
        return $this->userRepository->findById($id);
    }

    public function getByEmail($id)
    {
        return $this->userRepository->findByEmail($id);
    }

    public function updateUserById($id, $user)
    {
        return $this->userRepository->update($id, $user);
    }

    public function paginateParticipant($paginationDataFromRequest)
    {
        $limit = $paginationDataFromRequest['limit'];
        $sortColumn = $paginationDataFromRequest['sort_column'];
        $sortType = $paginationDataFromRequest['sort_type'];
        $filterColumn = $paginationDataFromRequest['filter_column'];
        $filterData = $paginationDataFromRequest['filter_data'];
        $searchData = $paginationDataFromRequest['search_data'];

        return $this->userRepository->paginateParticipant($limit, $sortColumn, $sortType, $filterColumn, $filterData, $searchData);
    }

    public function getUsersByIdEventAndStatus($idEvent, $status)
    {
        return $this->userRepository->getUserByIdEventEndStatusEvent($idEvent, $status);
    }

    public function getUsersByIdEvent($idEvent)
    {
        return $this->userRepository->getUserByIdEvent($idEvent);
    }

    public function getUserProfileByIdAndSumPointNumberAndCountEventJoin($idUser)
    {
        $userFromDB = $this->getUserById($idUser);
        $userFromDB['sum_point_number'] = $this->eventUserRepository->findSumPointNumberByIdUser($idUser)[0];
        $userFromDB['sum_event_join'] = count($this->eventUserRepository->findAllByIdUser($idUser));
        return $userFromDB;
    }

    public function getCountParticipant()
    {
        return $this->userRepository->getCountParticipant();
    }
}
