<?php

namespace App\DTOs\EventUser;

use App\DTOs\DTO;

class AcceptedUserJoinToEventDTO extends DTO
{
    private $validate_request_schema = [
        'id' => 'required',
    ];

    public function __construct()
    {
        parent::__construct($this->validate_request_schema);
    }
}
