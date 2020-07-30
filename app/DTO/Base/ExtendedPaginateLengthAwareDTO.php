<?php


namespace App\DTO\Base;


use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ExtendedPaginateLengthAwareDTO extends PaginateLengthAwareDTO
{
    /**
     * @var LengthAwarePaginator
     */
    private $paginator;

    /**
     * PaginateLengthAwareDTO constructor.
     * @param LengthAwarePaginator $paginator
     */
    public function __construct(LengthAwarePaginator $paginator)
    {
        parent::__construct($paginator);

        $this->paginator = $paginator;

        $this->setDefaultData();
    }

    /**
     * @return void
     */
    private function setDefaultData(): void
    {
        $lastPage = $this->paginator->lastPage();

        $this->setCurrentPage($this->paginator->currentPage())
            ->setData()
            ->setExtendedData()
            ->setTotal($this->paginator->total())
            ->setPerPage($this->paginator->perPage())
            ->setFirstPageUrl($this->paginator->url(1))
            ->setLastPageUrl($this->paginator->url($lastPage))
            ->setNextPageUrl($this->paginator->nextPageUrl())
            ->setPrevPageUrl($this->paginator->previousPageUrl());
    }

    /**
     * @param DTO $data
     * @return PaginateDTO
     */
    public function setExtendedData(?DTO $data = null): PaginateDTO
    {
        $this->content->put('extended_data', $data ?? []);

        return $this;
    }
}
