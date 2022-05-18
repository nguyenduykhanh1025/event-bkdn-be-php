<?php

namespace App\DTOs;

use Validator;

class DTO
{
    private $validateSchema;

    public function __construct($validateSchema)
    {
        $this->validateSchema = $validateSchema;
    }

    public function validateRequest($request)
    {
        $result = [
            'is_error' => false,
            'data' => null
        ];
        $validator = Validator::make($request->all(), $this->validateSchema);

        if ($validator->fails()) {
            $result['is_error'] = true;
            $result['data'] = $validator->errors();
        } else {
            $result['data'] = $validator->validated();
        }

        return $result;
    }

    public function validateData($data)
    {
        $result = [
            'is_error' => false,
            'data' => null
        ];
        $validator = Validator::make($data, $this->validateSchema);

        if ($validator->fails()) {
            $result['is_error'] = true;
            $result['data'] = $validator->errors();
        } else {
            $result['data'] = $validator->validated();
        }

        return $result;
    }
}
