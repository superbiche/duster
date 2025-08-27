<?php

namespace App\Contracts;

use App\Concerns\CommandHelpers;
use App\Concerns\GetsCpuCount;
use App\Support\DusterConfig;

abstract class Tool
{
    use CommandHelpers;
    use GetsCpuCount;

    public function __construct(
        protected DusterConfig $dusterConfig,
    ) {}

    abstract public function lint(): int;

    abstract public function fix(): int;
}
