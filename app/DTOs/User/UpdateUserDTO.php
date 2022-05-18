<?php

namespace App\DTOs\User;

use App\DTOs\DTO;

class UpdateUserDTO extends DTO
{
    private $validate_request_schema = [
        'first_name' => 'required',
        'last_name' => 'required'
    ];

    public function __construct()
    {
        parent::__construct($this->validate_request_schema);
    }
}
