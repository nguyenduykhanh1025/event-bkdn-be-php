<?php

namespace App\DTOs\Journal;

use App\DTOs\DTO;

class NewJournalDTO extends DTO
{
    private $validate_request_schema = [
        'title' => 'required',
        'description' => 'required',
        'images_str' => 'required',
    ];

    public function __construct()
    {
        parent::__construct($this->validate_request_schema);
    }
}
