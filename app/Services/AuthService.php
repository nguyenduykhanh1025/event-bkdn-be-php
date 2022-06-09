<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthService
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function createAdminAccountFromRequestData($request)
    {
        $dataNeedCreate = $request;
        $dataNeedCreate['password'] = Hash::make($request['password']);

        try {
            $user = $this->userRepository->create($dataNeedCreate);
            $user->assignRole(config('constants.role.ADMIN'));
            return $user;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return null;
        }
    }

    public function createParticipantFromRequestData($request)
    {
        $dataNeedCreate = $request;
        $dataNeedCreate['password'] = Hash::make($request['password']);

        try {
            $user = $this->userRepository->store($dataNeedCreate);
            $user->assignRole(config('constants.role.PARTICIPANT'));
            return $user;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            echo $e->getMessage();
            return null;
        }
    }

    public function checkUsernameIsExist($username)
    {
        if ($this->userRepository->getByUsername(($username)) == null) {
            return false;
        }
        return true;
    }
}
