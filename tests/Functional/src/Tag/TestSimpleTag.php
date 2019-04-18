<?php

declare(strict_types=1);

namespace Assoconnect\MJMLBundle\Tests\Functional\App\Tag;

use Assoconnect\MJMLBundle\Tag\TagInterface;

class TestSimpleTag implements TagInterface
{
    public function getName(): string
    {
        return 'asc-test-simple';
    }

    public function getAttributes(): iterable
    {
        return [];
    }

    public function getMJML(string $body, iterable $attributes): string
    {
        return '<mj-text>' . $body . '</mj-text>';
    }
}
