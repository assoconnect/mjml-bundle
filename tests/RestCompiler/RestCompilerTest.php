<?php

declare(strict_types=1);

namespace Assoconnect\MJMLBundle\Tests\RestCompiler;

use Assoconnect\MJMLBundle\Tests\Functional\App\RestTestKernel;
use Assoconnect\MJMLBundle\Tests\Functional\App\TestCase;

class RestCompilerTest extends TestCase
{
    public static function getKernelClass()
    {
        return RestTestKernel::class;
    }

    public function testSuccess()
    {
        // Kernel booting will clear the cache and warm it up
        self::bootKernel();
        $this->helperSuccess();
    }
}
