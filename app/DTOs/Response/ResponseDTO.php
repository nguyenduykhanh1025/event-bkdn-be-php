<?php

namespace App\DTOs\Response;

use App\DTOs\DTO;

class ResponseDTO extends DTO
{
    private $data;
    private $message;

    public function __construct()
    {
        parent::__construct(null);
        $this->data = '';
        $this->message = '';
    }

    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    public function getResponse()
    {
        return [
            'data' => $this->data,
            'message' => $this->message
        ];
    }
}
