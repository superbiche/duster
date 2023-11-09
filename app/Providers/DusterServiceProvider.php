<?php

namespace Tightenco\Duster\App\Providers;

use Tightenco\Duster\App\Project;
use Tightenco\Duster\App\Support\DusterConfig;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Console\Input\InputInterface;

class DusterServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(DusterConfig::class, function () {
            $input = $this->app->get(InputInterface::class);

            $mode = match ($input->getArgument('command')) {
                'lint' => 'lint',
                'fix' => 'fix',
                default => 'other',
            };

            $dusterConfig = DusterConfig::loadLocal();

            return new DusterConfig([
                'paths' => Project::paths($input),
                'using' => $input->getOption('using'),
                'mode' => $mode,
                'include' => $dusterConfig['include'] ?? [],
                'exclude' => $dusterConfig['exclude'] ?? [],
                'scripts' => $dusterConfig['scripts'] ?? [],
            ]);
        });
    }
}
