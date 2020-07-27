<?php

namespace App\DTO\Base;

class CollectionDTO extends DTO
{
    /** @var $collection */
    private $collection;

    /**
     * CollectionDTO constructor.
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->collection = collect($data);
    }

    /**
     * @param DTO $item
     * @return $this
     */
    public function pushItem(DTO $item): CollectionDTO
    {
        $this->collection->push($item);

        return $this;
    }


    /**
     * @return array
     */
    protected function jsonData(): array
    {
        return $this->collection->toArray();
    }

}
