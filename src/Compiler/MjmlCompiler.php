<?php

declare(strict_types=1);

namespace Assoconnect\MJMLBundle\Compiler;

use Symfony\Component\Process\Process;

/**
 * Compiles a MJML file to an HTML file
 */
class MjmlCompiler
{
    public function compile(string $input, string $output)
    {
        $command = [
            'mjml',
            $input,
            '-o',
            $output,
            '--config.validationLevel=strict',
        ];
        $process = new Process($command);
        $process->mustRun();
    }
}
