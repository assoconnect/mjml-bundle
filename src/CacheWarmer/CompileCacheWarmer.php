<?php

declare(strict_types=1);

namespace Assoconnect\MJMLBundle\CacheWarmer;

use Assoconnect\MJMLBundle\Compiler\Compiler;
use Assoconnect\MJMLBundle\Finder\TemplateFinder;
use Symfony\Component\HttpKernel\CacheWarmer\CacheWarmerInterface;

/**
 * Find all /template/mjml*.mjml.twig files to compiled the MJML code
 * to HTML code and store the templates in the same folder
 */
class CompileCacheWarmer implements CacheWarmerInterface
{
    private $compiler;

    private $templateFinder;

    public function __construct(
        Compiler $compiler,
        TemplateFinder $templateFinder
    ) {
        $this->compiler = $compiler;
        $this->templateFinder = $templateFinder;
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
        // Find custom templates
        $files = $this->templateFinder->find();

        foreach ($files as $file) {
            $this->compiler->compile($file);
        }
    }
}
