<?php

namespace Tightenco\Duster\App\Commands;

use Tightenco\Duster\App\Support\ConfiguresForLintOrFix;
use Tightenco\Duster\App\Support\GetsCleaner;
use Exception;
use LaravelZero\Framework\Commands\Command;
use LaravelZero\Framework\Exceptions\ConsoleException;

class FixCommand extends Command
{
    use ConfiguresForLintOrFix;
    use GetsCleaner;

    protected $signature = 'fix';

    protected $description = 'Fix your code';

    public function handle(): int
    {
        try {
            $clean = $this->getCleaner('fix', $this->input->getOption('using'));

            return $clean->execute();
        } catch (ConsoleException $exception) {
            $this->error($exception->getMessage());

            return $exception->getCode();
        } catch (Exception $exception) {
            $this->error($exception->getMessage());

            return 1;
        }
    }
}
