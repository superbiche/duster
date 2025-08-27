<?php

namespace App\Contracts;

use App\Concerns\CommandHelpers;
use App\Concerns\GetsCpuInfo;
use App\Support\DusterConfig;
use Fidry\CpuCoreCounter\CpuCoreCounter;
use Fidry\CpuCoreCounter\Finder\DummyCpuCoreFinder;
use Fidry\CpuCoreCounter\Finder\FinderRegistry;

abstract class Tool
{
    use CommandHelpers;

    public function __construct(
        protected DusterConfig $dusterConfig,
    ) {}

    abstract public function lint(): int;

    abstract public function fix(): int;

    public function getCpuCount(): int
    {
        return (new CpuCoreCounter())->getCountWithFallback(4);
    }
}
