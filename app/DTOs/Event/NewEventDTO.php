<?php

namespace App\DTOs\Event;

use App\DTOs\DTO;

class NewEventDTO extends DTO
{
    private $validate_request_schema = [
        'title' => 'required',
        'description' => 'required',
        'description_participant' => 'required',
        'description_required' => 'required',
        'count_need_participate' => 'required',
        'start_at' => 'required',
        'end_at' => 'required',
        'address' => 'required',
        'images_str' => 'required',
        'point_number' => 'nullable'
    ];

    public function __construct()
    {
        parent::__construct($this->validate_request_schema);
    }
}
