<?php

use Realodix\Relax\Config;
use Realodix\Relax\Finder;

$localRules = [
    // ...
];

return Config::create('relax')
    ->setRules($localRules)
    ->setFinder(Finder::laravel()->in(__DIR__));
