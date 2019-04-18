<?php

declare(strict_types=1);

namespace Assoconnect\MJMLBundle\CacheWarmer;

use Assoconnect\MJMLBundle\Compiler\CustomCompiler;
use Assoconnect\MJMLBundle\Compiler\MjmlCompiler;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\HttpKernel\CacheWarmer\CacheWarmerInterface;

/**
 * Find all /template/mjml*.mjml.twig files to compiled the MJML code
 * to HTML code and store the templates in the same folder
 */
class CompileCacheWarmer implements CacheWarmerInterface
{

    private $customCompiler;

    private $mjmlCompiler;

    private $projectDir;

    public function __construct(
        CustomCompiler $customCompiler,
        MjmlCompiler $mjmlCompiler,
        string $projectDir
    ) {
        $this->customCompiler = $customCompiler;
        $this->mjmlCompiler = $mjmlCompiler;
        $this->projectDir = $projectDir;
    }

    /**
     * {@inheritdoc}
     */
    public function isOptional()
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function warmUp($cacheDir)
    {
        // Tmp folder
        $tmpDir = $cacheDir . '/assoconnect/mjml';
        $this->ensureDirExists($tmpDir);

        // HTML folder
        $htmlDir = $this->projectDir . '/templates/mjml';
        $this->ensureDirExists($htmlDir);

        // Find custom templates
        $finder = new Finder();
        $files = $finder
            ->files()
            ->in($this->projectDir . '/templates/mjml')
            ->name('*.mjml.twig');

        /** @var SplFileInfo[] $files */
        foreach ($files as $file) {
            $mjmlFile = $file->getRealPath();

            $contents = file_get_contents($mjmlFile);

            // Compiling custom tags to MJML
            $mjml = $this->customCompiler->compile($contents);

            // There was some custom tags
            if ($mjml !== $contents) {
                // We'll compile a tmp file
                $mjmlFile = $tmpDir . '/' . $file->getFilename();
                file_put_contents($mjmlFile, $mjml);
            }

            // MJML => HTML
            $htmlFilename = str_replace('.mjml.', '.html.', $file->getFilename());
            $htmlFile = $htmlDir . '/' . $htmlFilename;
            $this->mjmlCompiler->compile($mjmlFile, $htmlFile);
        }
    }

    private function ensureDirExists($dir): void
    {
        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }
    }
}
