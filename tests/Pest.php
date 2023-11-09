<?php

use Tightenco\Duster\App\DusterKernel;
use Illuminate\Support\Arr;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Tests\TestCase;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

uses(TestCase::class)->in('Feature', 'Fixer');

// Move to test directory to prevent Duster's own config files being used
uses()
    ->beforeEach(fn () => chdir(__DIR__))
    ->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', fn () => $this->toBe(1));

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

/**
 * Runs the given console command.
 *
 * @param  string  $command
 * @param  array<string, string>  $arguments
 * @return array{int, BufferedOutput}
 */
function run($command, $arguments)
{
    $arguments = array_merge([$command], $arguments);
    $arguments['path'] = Arr::wrap($arguments['path']);

    $input = new ArrayInput($arguments);
    $output = new BufferedOutput(
        BufferedOutput::VERBOSITY_VERBOSE,
    );

    app()->singleton(InputInterface::class, fn () => $input);
    app()->singleton(OutputInterface::class, fn () => $output);

    $statusCode = resolve(DusterKernel::class)->handle($input, $output);

    $output = preg_replace('#\\x1b[[][^A-Za-z]*[A-Za-z]#', '', $output->fetch());

    return [$statusCode, $output];
}
