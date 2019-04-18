<?php

declare(strict_types=1);

namespace Assoconnect\MJMLBundle\Tests\Functional\App\Tag;

use Assoconnect\MJMLBundle\Tag\TagInterface;

class TestWithAttributesTag implements TagInterface
{
    public function getName(): string
    {
        return 'asc-test-attributes';
    }

    public function getAttributes(): iterable
    {
        return [
            'foo' => 'bar',
            'hello' => 'world',
        ];
    }

    public function getMJML(string $body, iterable $attributes): string
    {
        $mjml = [
            'a="b"',
            'foo="' . $attributes['foo'] . '"',
            'hello="' . $attributes['hello'] . '"',
        ];

        return '<mjml-raw ' . implode(' ', $mjml) . '>' . $body . '</mjml-raw>';
    }
}
