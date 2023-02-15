<?php

namespace App\Models\Traits;

use App\Services\HashidsService;

trait Hashidable
{
    /**
     * Get the value of the model's route key.
     *
     * @return string
     */
    public function getRouteKey()
    {
        return app(HashidsService::class)->encode($this->getKey());
    }
}
