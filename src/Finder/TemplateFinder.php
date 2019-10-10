<?php

declare(strict_types=1);

namespace Assoconnect\MJMLBundle\Finder;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class TemplateFinder
{
    protected $projectDir;

    /**
     * @var array
     */
    private $templatePaths;

    public function __construct(string $projectDir, array $templatePaths)
    {
        $this->projectDir = $projectDir;
        $this->templatePaths = $templatePaths;
    }

    /**
     * Finds template to compiler
     *
     * @return SplFileInfo[]
     */
    public function find(string $patterns = null): iterable
    {
        $templates = [];
        foreach ($this->templatePaths as $templatePath) {
            $finder = new Finder();

            $templateIterator = $finder
                ->files()
                ->in($this->projectDir . $templatePath)
                ->name($patterns ?? '*.mjml.twig')
                ->getIterator();
            array_push(
                $templates,
                ... array_values(iterator_to_array($templateIterator))
            );
        }

        $this->findDuplicates($templates);

        return $templates;
    }

    private function findDuplicates($templates)
    {
        $templatesNames = array_map(function (SplFileInfo $a) {
            return $a->getFilename();
        }, $templates);

        $duplicates = array();
        foreach (array_count_values($templatesNames) as $val => $c) {
            if ($c > 1) {
                $duplicates[] = $val;
            }
        }
        
        if (array_count_values($duplicates)) {
            throw new DuplicatesTemplatesNameException(sprintf(
                'Duplicates template name found %s',
                implode(',', $duplicates)
            ));
        }
    }
}
