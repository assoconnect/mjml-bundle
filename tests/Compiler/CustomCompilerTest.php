<?php

declare(strict_types=1);

namespace Assoconnect\MJMLBundle\Tests\Compiler;

use Assoconnect\MJMLBundle\Compiler\CustomCompiler;
use Assoconnect\MJMLBundle\Tests\Functional\App\Tag\TestSimpleTag;
use Assoconnect\MJMLBundle\Tests\Functional\App\Tag\TestWithAttributesTag;
use PHPUnit\Framework\TestCase;

class CustomCompilerTest extends TestCase
{
    private function getCompiler(): CustomCompiler
    {
        $tags = [
            new TestSimpleTag(),
            new TestWithAttributesTag(),
        ];
        return new CustomCompiler($tags);
    }

    /**
     * No attributes
     * No body
     */
    public function testCompileNoAttributesNoBody()
    {
        $compiler = $this->getCompiler();
        $contents = '<asc-test-simple></asc-test-simple>';
        $mjml = '<mj-text></mj-text>';

        $this->assertSame($mjml, $compiler->compile($contents));
    }

    /**
     * No attributes
     * With body
     */
    public function testCompileNoAttributesWithBody()
    {
        $compiler = $this->getCompiler();
        $contents = '<asc-test-simple>Hello world!</asc-test-simple>';
        $mjml = '<mj-text>Hello world!</mj-text>';

        $this->assertSame($mjml, $compiler->compile($contents));
    }

    /**
     * With attributes
     * Default values
     */
    public function testCompileWithAttributesDefaultValues()
    {
        $compiler = $this->getCompiler();
        $contents = '<asc-test-attributes>Hello world!</asc-test-attributes>';
        $mjml = '<mjml-raw a="b" foo="bar" hello="world">Hello world!</mjml-raw>';

        $this->assertSame($mjml, $compiler->compile($contents));
    }

    /**
     * With attributes
     * Custom values
     */
    public function testCompileWithAttributesCustomValues()
    {
        $compiler = $this->getCompiler();
        $contents = '<asc-test-attributes foo="baz" hello="you">Hello world!</asc-test-attributes>';
        $mjml = '<mjml-raw a="b" foo="baz" hello="you">Hello world!</mjml-raw>';

        $this->assertSame($mjml, $compiler->compile($contents));
    }

    /**
     * With attributes
     * Custom values
     */
    public function testCompileMultiple()
    {
        $compiler = $this->getCompiler();
        $contents = <<<EOD
<asc-test-simple>Line 1</asc-test-simple>
<asc-test-simple>Line 2</asc-test-simple>
EOD;
        $mjml = <<<EOD
<mj-text>Line 1</mj-text>
<mj-text>Line 2</mj-text>
EOD;

        $this->assertSame($mjml, $compiler->compile($contents));
    }
}
