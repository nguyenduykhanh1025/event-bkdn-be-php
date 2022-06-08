<?php

namespace App\DTOs\EventUser;

use App\DTOs\DTO;

class RemoveToEventDTO extends DTO
{
    private $validate_request_schema = [
        'id_event' => 'required',
        'id_user' => 'required'
    ];

    public function __construct()
    {
        parent::__construct($this->validate_request_schema);
    }
}
