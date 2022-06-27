<?php

namespace App\DTOs\User;

use App\DTOs\DTO;

class UpdateExponentPushTokenDTO extends DTO
{
    private $validate_request_schema = [
        'exponent_push_token' => 'required',
    ];

    public function __construct()
    {
        parent::__construct($this->validate_request_schema);
    }
}
