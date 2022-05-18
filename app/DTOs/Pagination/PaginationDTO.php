<?php

namespace App\DTOs\Pagination;

use App\DTOs\DTO;
use Illuminate\Validation\Rule;

class PaginationDTO extends DTO
{
    private $validate_request_schema;

    public function __construct()
    {
        $this->validate_request_schema = [
            'limit' => 'nullable|numeric',
            'sort_column' => 'nullable',
            'sort_type' => array('nullable', Rule::in(['asc', 'desc'])),
            'filter_column' => 'nullable',
            'filter_data' => 'nullable',
            'search_data' => 'nullable'
        ];

        parent::__construct($this->validate_request_schema);
    }

    public function validateRequest($request)
    {
        $result =  parent::validateRequest($request);
        if ($result['is_error']) {
            return $result;
        }

        $data = $result['data'];
        $data['limit'] = $data['limit'] ?? config('constants.paginate.PER_PAGE');
        $result['data'] = $data;
        return $result;
    }
}
