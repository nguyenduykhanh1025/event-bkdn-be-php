<?php

namespace App\DTOs\Auth;

use App\DTOs\DTO;

class NewAdminDTO extends DTO
{
    private $validate_request_schema = [
        'email' => 'email|max:255',
        'password' => 'required|min:6',
        'first_name' => 'required|max:255',
        'last_name' => 'required|max:255',
    ];

    public function __construct()
    {
        parent::__construct($this->validate_request_schema);
    }
}
