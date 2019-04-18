<?php

declare(strict_types=1);

namespace Assoconnect\MJMLBundle\Tests\Compiler;

use Assoconnect\MJMLBundle\Compiler\MjmlCompiler;
use PHPUnit\Framework\TestCase;

class MjmlCompilerTest extends TestCase
{
    public function testCompile()
    {
        $testFolder = realpath(__DIR__ . '/../Functional');
        $input = $testFolder . '/templates/test.mjml';

        $tmpFolder = $testFolder . '/var/tmp';
        if (!is_dir($tmpFolder)) {
            mkdir($tmpFolder, 0775, true);
        }
        $output = $tmpFolder . '/output.html';

        $compiler = new MjmlCompiler();
        $compiler->compile($input, $output);

        $this->assertFileExists($output);
    }
}
