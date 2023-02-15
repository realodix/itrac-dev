<?php

namespace App\Models\Traits;

use Hashids\Hashids;

trait Hashidable
{
    /**
     * Get the encoded value of the model's route key.
     *
     * @return string
     */
    public function encodedId()
    {
        $hashids = new Hashids('', 16);

        return $hashids->encode($this->getKey());
    }
}
