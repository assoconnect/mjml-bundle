<?php

declare(strict_types=1);

namespace Assoconnect\MJMLBundle\Compiler;

use Symfony\Component\Finder\SplFileInfo;

class Compiler
{
    private $customCompiler;

    private $mjmlCompiler;

    private $htmlDir;

    private $tmpDir;

    public function __construct(
        CustomCompiler $customCompiler,
        MjmlCompiler $mjmlCompiler,
        string $cacheDir,
        string $projectDir
    )
    {
        $this->customCompiler = $customCompiler;
        $this->mjmlCompiler = $mjmlCompiler;

        // HTML folder
        $this->htmlDir = $projectDir . '/templates/mjml';
        $this->ensureDirExists($this->htmlDir);

        // Tmp folder
        $this->tmpDir = $cacheDir . '/assoconnect/mjml';
        $this->ensureDirExists($this->tmpDir);
    }

    /**
     * Compiles a MJML template with custom tags to HTML
     * @param SplFileInfo $file
     */
    public function compile(SplFileInfo $file)
    {
        $mjmlFile = $file->getRealPath();

        $contents = file_get_contents($mjmlFile);

        // Compiling custom tags to MJML
        $mjml = $this->customCompiler->compile($contents);

        // There was some custom tags
        if ($mjml !== $contents) {
            // We'll compile a tmp file
            $mjmlFile = $this->tmpDir . '/' . $file->getFilename();
            file_put_contents($mjmlFile, $mjml);
        }

        // MJML => HTML
        $htmlFilename = str_replace('.mjml.', '.html.', $file->getFilename());
        $htmlFile = $this->htmlDir . '/' . $htmlFilename;
        $this->mjmlCompiler->compile($mjmlFile, $htmlFile);
    }

    private function ensureDirExists($dir): void
    {
        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }
    }
}