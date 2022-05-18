<?php

namespace App\DTOs\Auth;

use App\DTOs\DTO;

class AuthLoginWithEmailAndPasswordDTO extends DTO
{
    private $validate_request_schema = [
        'email' => 'required|email',
        'password' => 'required|min:6' 
    ];

    public function __construct()
    {
        parent::__construct($this->validate_request_schema);
    }
}
