<?php

namespace App\DTOs\Auth;

use App\DTOs\DTO;

class NewParticipantDTO extends DTO
{
    private $validate_request_schema = [
        'first_name' => 'required',
        'last_name' => 'nullable',
        'email' => 'required',
        'phone_number' => 'required',
        'id_student' => 'required',
        'password' => 'required',
    ];

    public function __construct()
    {
        parent::__construct($this->validate_request_schema);
    }
}
