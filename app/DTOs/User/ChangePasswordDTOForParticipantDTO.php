<?php

namespace App\DTOs\User;

use App\DTOs\DTO;

class ChangePasswordDTOForParticipantDTO extends DTO
{
    private $validate_request_schema = [
        'current_password' => 'required',
        'new_password' => 'required',
    ];

    public function __construct()
    {
        parent::__construct($this->validate_request_schema);
    }
}
