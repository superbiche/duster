<?php

namespace Tightenco\Duster\App\Providers;

use Tightenco\Duster\App\Actions\ElaborateSummary;
use Tightenco\Duster\App\Actions\FixCode;
use Tightenco\Duster\App\Commands\DefaultCommand;
use Tightenco\Duster\App\Contracts\PathsRepository;
use Tightenco\Duster\App\Contracts\PintInputInterface;
use Tightenco\Duster\App\Output\ProgressOutput;
use Tightenco\Duster\App\Output\SummaryOutput;
use Tightenco\Duster\App\Project;
use Tightenco\Duster\App\Repositories\ConfigurationJsonRepository;
use Tightenco\Duster\App\Repositories\GitPathsRepository;
use Tightenco\Duster\App\Repositories\PintConfigurationJsonRepository;
use Tightenco\Duster\App\Support\DusterConfig;
use Illuminate\Support\ServiceProvider;
use PhpCsFixer\Error\ErrorsManager;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

class PintServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(ErrorsManager::class, fn () => new ErrorsManager);

        $this->app->singleton(EventDispatcher::class, fn () => new EventDispatcher);

        $this->app->singleton(PintInputInterface::class, function () {
            $input = $this->app->get(InputInterface::class);

            return new ArrayInput(
                ['--test' => $input->getArgument('command') === 'lint', 'path' => Project::paths($input)],
                resolve(DefaultCommand::class)->getDefinition()
            );
        });

        $this->app->singleton(FixCode::class, fn () => new FixCode(
            resolve(ErrorsManager::class),
            resolve(EventDispatcher::class),
            resolve(PintInputInterface::class),
            resolve(OutputInterface::class),
            new ProgressOutput(
                resolve(EventDispatcher::class),
                resolve(PintInputInterface::class),
                resolve(OutputInterface::class),
            )
        ));

        $this->app->singleton(ElaborateSummary::class, fn () => new ElaborateSummary(
            resolve(ErrorsManager::class),
            resolve(PintInputInterface::class),
            resolve(OutputInterface::class),
            new SummaryOutput(
                resolve(ConfigurationJsonRepository::class),
                resolve(ErrorsManager::class),
                resolve(PintInputInterface::class),
                resolve(OutputInterface::class),
            )
        ));

        $this->app->singleton(ConfigurationJsonRepository::class, function () {
            $config = (string) collect([
                Project::path() . '/pint.json',
                base_path('standards/pint.json'),
            ])->first(fn ($path) => file_exists($path));

            $dusterConfig = DusterConfig::scopeConfigPaths(DusterConfig::loadLocal());

            return new PintConfigurationJsonRepository($config, null, $dusterConfig['exclude']);
        });

        $this->app->singleton(PathsRepository::class, function () {
            return new GitPathsRepository(
                Project::path(),
            );
        });
    }
}
