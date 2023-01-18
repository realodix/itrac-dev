<?php

use App\Helpers\Helper;

if (! function_exists('compactNumber')) {
    /**
     * \App\Helpers\Helper::compactNumber()
     *
     * @param int $value
     * @return int|string
     */
    function compactNumber($value)
    {
        return Helper::compactNumber($value);
    }
}
