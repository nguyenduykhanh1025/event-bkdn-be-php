<?php

namespace App\DTOs\EventUser;

use App\DTOs\DTO;

class JoinToEventDTO extends DTO
{
    private $validate_request_schema = [
        'id_event' => 'required',
        'email' => 'required'
    ];

    public function __construct()
    {
        parent::__construct($this->validate_request_schema);
    }
}
