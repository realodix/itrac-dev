<?php

namespace App\Services;

use Hashids\Hashids;

class HashidsService
{
    public Hashids $hashids;

    public function __construct(string $salt, int $minHashLength, string $alphabet)
    {
        $this->hashids = new Hashids($salt, $minHashLength, $alphabet);
    }

    /**
     * Encode parameters to generate a hash.
     *
     * @param string|array<int, string> $numbers
     */
    public function encode(...$numbers): string
    {
        return $this->hashids->encode($numbers);
    }

    /**
     * Decode a hash to the original parameter values.
     *
     * @return array<int, string>
     */
    public function decode(string $hash): array
    {
        return $this->hashids->decode($hash);
    }

    /**
     * Encode hexadecimal values and generate a hash string.
     */
    public function encodeHex(string $str): string
    {
        return $this->hashids->encodeHex($str);
    }

    /**
     * Decode a hash string to hexadecimal values.
     */
    public function decodeHex(string $hash): string
    {
        return $this->hashids->decodeHex($hash);
    }
}
