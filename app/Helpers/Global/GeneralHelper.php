<?php

use App\Helpers\Helper;

if (! function_exists('compactNumber')) {
    /**
     * \App\Helpers\Helper::compactNumber()
     *
     * @codeCoverageIgnore
     *
     * @param int $value
     * @return int|string
     */
    function compactNumber($value)
    {
        return Helper::compactNumber($value);
    }
}
