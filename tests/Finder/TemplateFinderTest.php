<?php

declare(strict_types=1);

namespace Assoconnect\MJMLBundle\Tests\Finder;

use Assoconnect\MJMLBundle\Finder\TemplateFinder;
use PHPUnit\Framework\TestCase;

class TemplateFinderTest extends TestCase
{
    public function testFindDefault()
    {
        $finder = new TemplateFinder(__DIR__ . '/../Functional');

        $templates = $finder->find();

        $this->assertCount(1, $templates);

        $template = array_pop($templates);
        $this->assertSame('custom.mjml.twig', $template->getFilename());
    }

    public function testFindOne()
    {
        $finder = new TemplateFinder(__DIR__ . '/../Functional');

        $templates = $finder->find('custom.mjml.twig');

        $this->assertCount(1, $templates);

        $template = array_pop($templates);
        $this->assertSame('custom.mjml.twig', $template->getFilename());
    }

    public function testNotFound()
    {
        $finder = new TemplateFinder(__DIR__ . '/../Functional');

        $templates = $finder->find('not_found.mjml.twig');

        $this->assertCount(0, $templates);
    }
}
