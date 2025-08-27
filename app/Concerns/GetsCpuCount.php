<?php

declare(strict_types=1);

namespace App\Concerns;
use Fidry\CpuCoreCounter\CpuCoreCounter;

trait GetsCpuCount
{
    public function getCpuCount(): int
    {
        return (new CpuCoreCounter())->getCountWithFallback(4);
    }
}
