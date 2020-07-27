<?php

namespace App\DTO\Base;

use JsonSerializable;

abstract class DTO implements JsonSerializable
{
    /**
     * @return array
     */
    abstract protected function jsonData(): array;

    /**
     * @see JsonSerializable::jsonSerialize()
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->jsonData();
    }
}
