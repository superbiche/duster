<?php

declare(strict_types=1);

namespace App\Concerns;

trait GetsCpuInfo
{
    public function getNumberOfCores(): int
    {
        return (int) match (PHP_OS_FAMILY) {
          'Windows' => shell_exec('echo %NUMBER_OF_PROCESSORS%'),
          'Darwin' => shell_exec('sysctl -n hw.logicalcpu'),
          'Linux' => shell_exec('nproc'),
          default => 4,
        };
    }
}
