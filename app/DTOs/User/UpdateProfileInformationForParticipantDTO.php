<?php

namespace App\DTOs\User;

use App\DTOs\DTO;

class UpdateProfileInformationForParticipantDTO extends DTO
{
    private $validate_request_schema = [
        'first_name' => 'required',
        'phone_number' => 'required',
        'id_student' => 'required',
    ];

    public function __construct()
    {
        parent::__construct($this->validate_request_schema);
    }
}
