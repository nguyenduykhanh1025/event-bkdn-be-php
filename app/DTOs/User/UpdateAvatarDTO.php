<?php

namespace App\DTOs\User;

use App\DTOs\DTO;

class UpdateAvatarDTO extends DTO
{
    private $validate_request_schema = [
        'avatar' => 'required',
    ];

    public function __construct()
    {
        parent::__construct($this->validate_request_schema);
    }
}
