<?php

declare(strict_types=1);

namespace Assoconnect\MJMLBundle\Tests\Functional\App;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

class BootTest extends KernelTestCase
{
    public static function getKernelClass()
    {
        return TestKernel::class;
    }

    /**
     * Kernel booting will trigger a cache warming up
     * We just need to ensure that the html file is resolved
     * and that it does not contain any <mj-XXX> tag nor <asc-XXX>
     */
    public function testSuccess()
    {
        // We first remove the legacy files
        $finder = new Finder();
        $files = $finder
            ->files()
            ->in(__DIR__ . '/../templates/mjml')
            ->name('*.html.twig');
        foreach ($files as $file) {
            unlink($file->getRealPath());
        }

        $filesystem = new Filesystem();
        if ($folder = realpath(__DIR__ . '/../var')) {
            $filesystem->remove($folder);
        }

        // Kernel booting will clear the cache and warm it up
        self::bootKernel();

        // New file exists
        $compiledFile = __DIR__ . '/../templates/mjml/custom.html.twig';
        $this->assertFileExists($compiledFile);

        // New file has been compiled
        $contents = file_get_contents($compiledFile);
        $this->assertStringNotContainsString('<mj-', $contents);
        $this->assertStringNotContainsString('<asc-', $contents);
    }
}
