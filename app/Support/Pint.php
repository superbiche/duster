<?php

namespace Tightenco\Duster\App\Support;

use Tightenco\Duster\App\Actions\ElaborateSummary;
use Tightenco\Duster\App\Actions\FixCode;
use Tightenco\Duster\App\Commands\DefaultCommand;

class Pint extends Tool
{
    public function lint(): int
    {
        $this->heading('Linting using Pint');

        return $this->process();
    }

    public function fix(): int
    {
        $this->heading('Fixing using Pint');

        return $this->process();
    }

    private function process(): int
    {
        $pint = new DefaultCommand;

        return $pint->handle(resolve(FixCode::class), resolve(ElaborateSummary::class));
    }
}
