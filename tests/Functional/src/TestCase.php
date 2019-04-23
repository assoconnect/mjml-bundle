<?php

declare(strict_types=1);

namespace Assoconnect\MJMLBundle\Tests\Functional\App;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

abstract class TestCase extends KernelTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->cleanUp();
    }

    /**
     * Removes files that are supposed to be created by the tests
     */
    protected function cleanUp()
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
    }

    public function helperSuccess()
    {
        // New file exists
        $compiledFile = __DIR__ . '/../templates/mjml/custom.html.twig';
        $this->assertFileExists($compiledFile);

        // New file has been compiled
        $contents = file_get_contents($compiledFile);
        $this->assertStringNotContainsString('<mj-', $contents);
        $this->assertStringNotContainsString('<asc-', $contents);
    }

    public static function getKernelClass()
    {
        return TestKernel::class;
    }
}
