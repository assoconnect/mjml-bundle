<?php

declare(strict_types=1);

namespace Assoconnect\MJMLBundle\Finder;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class TemplateFinder
{
    protected $projectDir;

    public function __construct(string $projectDir)
    {
        $this->projectDir = $projectDir;
    }

    /**
     * Finds template to compiler
     * @return SplFileInfo[]
     */
    public function find(string $patterns = null): iterable
    {
        $finder = new Finder();
        $templates = $finder
            ->files()
            ->in($this->projectDir . '/templates/mjml')
            ->name($patterns ?? '*.mjml.twig')
        ;

        return iterator_to_array($templates->getIterator());
    }
}