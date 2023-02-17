<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\Crypt;

trait Hashidable
{
    /**
     * Get the encoded value of the model's route key.
     *
     * @return string
     */
    public function getRouteKey()
    {
        return Crypt::encryptString($this->getKey());
    }
}
