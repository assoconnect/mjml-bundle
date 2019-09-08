<?php

declare(strict_types=1);

namespace Assoconnect\MJMLBundle\Compiler;

interface MjmlCompilerInterface
{
    public function compile(string $input, string $output);
}
