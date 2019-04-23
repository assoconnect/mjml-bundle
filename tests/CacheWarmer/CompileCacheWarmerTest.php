<?php

declare(strict_types=1);

namespace Assoconnect\MJMLBundle\Tests\CacheWarmer;

use Assoconnect\MJMLBundle\Tests\Functional\App\TestCase;

class CompileCacheWarmerTest extends TestCase
{
    /**
     * Kernel booting will trigger a cache warming up
     * We just need to ensure that the html file is resolved
     * and that it does not contain any <mj-XXX> tag nor <asc-XXX>
     */
    public function testSuccess()
    {
        // Kernel booting will clear the cache and warm it up
        self::bootKernel();

        $this->helperSuccess();
    }
}
