<?php

namespace App\DTOs\Pagination;

use App\DTOs\DTO;

class PaginationResponseDTO extends DTO
{
    private $items;
    private $metaCurrentPage;
    private $metaTotal;
    private $metaPerPage;


    public function __construct()
    {
        parent::__construct(null);
        $this->items = [];
        $this->metaCurrentPage = null;
        $this->metaTotal = null;
        $this->metaPerPage = null;

    }

    public function setItems($items)
    {
        $this->items = $items;
        return $this;
    }

    public function setMetaCurrentPage($metaCurrentPage)
    {
        $this->metaCurrentPage = $metaCurrentPage;
        return $this;
    }

    public function setMetaPerPage($metaPerPage)
    {
        $this->metaPerPage = $metaPerPage;
        return $this;
    }

    public function setMetaTotal($metaTotal)
    {
        $this->metaTotal = $metaTotal;
        return $this;
    }

    public function getResponse()
    {
        return [
            'items' => $this->items,
            'meta' => [
                'currentPage' => $this->metaCurrentPage,
                'total' => $this->metaTotal,
                'perPage' => $this->metaPerPage,
            ]
        ];
    }
}
