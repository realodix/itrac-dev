<?php

namespace App\Models\Traits;

trait Hashidable
{
    /**
     * Get the encoded value of the model's route key.
     *
     * @return string
     */
    public function getRouteKey()
    {
        return encrypt($this->getKey());
    }
}
