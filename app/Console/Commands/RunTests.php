<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class RunTests extends Command
{
    protected $signature = 'test
        {path? : Test file or directory to run}
        {--filter= : Filter which tests to run}';

    protected $description = 'Run the application test suite with PHPUnit';

    public function handle(): int
    {
        $command = [PHP_BINARY, base_path('vendor/bin/phpunit')];

        if ($filter = $this->option('filter')) {
            $command[] = '--filter';
            $command[] = $filter;
        }

        if ($path = $this->argument('path')) {
            $command[] = $path;
        }

        $process = new Process($command, base_path());
        $process->setTty(Process::isTtySupported());
        $process->setTimeout(null);

        return $process->run(function (string $type, string $buffer): void {
            $this->output->write($buffer);
        });
    }
}
