<?php

namespace App\DTOs\ManagerEvent;

use App\DTOs\DTO;

class NewManagerEventDTO extends DTO
{
    private $validate_request_schema = [
        'name' => 'required',
        'description' => 'required',
        'email' => 'required',
        'phone_number' => 'required',
        'sex' => 'required',
        'avatar' => 'required',
    ];

    public function __construct()
    {
        parent::__construct($this->validate_request_schema);
    }
}
