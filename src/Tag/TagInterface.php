<?php

declare(strict_types=1);

namespace Assoconnect\MJMLBundle\Tag;

interface TagInterface
{
    /**
     * Returns the tag name of the HTML tag this class defines
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Returns an associative array of attribute name as key and their default value as value
     *
     * @return string[]
     */
    public function getAttributes(): iterable;

    /**
     * Returns the MJML code of this custom tag
     *
     * @return string
     */
    public function getMJML(string $body, iterable $attributes): string;
}
