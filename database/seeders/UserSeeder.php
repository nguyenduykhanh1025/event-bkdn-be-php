<?php

namespace Database\Seeders;

use App\Repositories\UserRepository;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function run()
    {
        $this->createUserParticipantIfMissing('nguyenduykhanh1025@gmail.com', '123456');
        $this->createUserParticipantIfMissing('nguyenduykhanh1026@gmail.com', '123456');
        $this->createUserAdminIfMissing('nguyenduykhanh1027@gmail.com', '123456');
        $this->createUserAdminIfMissing('nguyenduykhanh1028@gmail.com', '123456');
    }

    protected function createUserParticipantIfMissing($email, $password)
    {
        if (empty($this->userRepository->findByEmail($email))) {
            $dataNeedCreate['password'] = Hash::make($password);
            $dataNeedCreate['email'] = $email;
            $dataNeedCreate['first_name'] = "Lan";
            $dataNeedCreate['last_name'] = "Nguyen";
            $dataNeedCreate['phone_number'] = "0382189922";
            $dataNeedCreate['avatar'] = "";
            $dataNeedCreate['info_description'] = "Adu adu adu";
            $user = $this->userRepository->store($dataNeedCreate);
            $user->assignRole(config('constants.ROLE.PARTICIPANT'));
        }
    }

    protected function createUserAdminIfMissing($email, $password)
    {
        if (empty($this->userRepository->findByEmail($email))) {
            $dataNeedCreate['password'] = Hash::make($password);
            $dataNeedCreate['email'] = $email;
            $dataNeedCreate['first_name'] = "Lan";
            $dataNeedCreate['last_name'] = "Nguyen";
            $dataNeedCreate['phone_number'] = "0382189922";
            $dataNeedCreate['avatar'] = "";
            $dataNeedCreate['info_description'] = "Adu adu adu";
            $user = $this->userRepository->store($dataNeedCreate);
            $user->assignRole(config('constants.ROLE.ADMIN'));
        }
    }
}
