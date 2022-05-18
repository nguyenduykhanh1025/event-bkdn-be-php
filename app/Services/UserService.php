<?php

namespace App\Services;

use App\Repositories\UserRepository;

class UserService
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
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

    public function updateUserById($id, $user)
    {
        return $this->userRepository->update($id, $user);
    }
}
