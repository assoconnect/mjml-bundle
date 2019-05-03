<?php

declare(strict_types=1);

namespace Assoconnect\MJMLBundle\Compiler;

use Assoconnect\MJMLBundle\Tag\TagInterface;

/**
 * This generator compiles custom tags into MJML
 */
class CustomCompiler
{
    /**
     * List of available custom tags
     *
     * @var TagInterface[]
     */
    private $tags;

    public function __construct(iterable $tags)
    {
        $this->tags = $tags;
    }

    /**
     * Returns compiled custom tags to MJML base components
     *
     * @param  string $contents MJML code with custom tags
     * @return string
     */
    public function compile(string $contents): string
    {
        $customTagFound = false;
        // We look for the custom tags in the template
        foreach ($this->tags as $tag) {
            $regex = $this->getRegexp($tag);
            if (preg_match_all($regex, $contents, $matches, PREG_SET_ORDER)) {
                $customTagFound = true;
                foreach ($matches as $match) {
                    // Converting to MJML
                    $mjml = $this->toMJML($tag, $match);
                    // Replacing in the contents
                    $contents = str_replace($match[0], $mjml, $contents);
                }
            }
        }

        // We have to replace all custom tags, so the compilation is needed while a custom tag is found and replaced
        if ($customTagFound) {
            return self::compile($contents);
        } else {
            return $contents;
        }
    }

    /**
     * Returns the regex to match custom tag attribute and body
     *
     * @param  TagInterface $tag
     * @return string
     */
    private function getRegexp(TagInterface $tag): string
    {
        $regexp = '';

        // Attribute name is a-z
        // Attribute value is #, a-z, A-Z, 0-9, -
        $regexAttributes = '([ #"=a-zA-Z0-9-]*)';

        // Tag opening
        $regexp .= '<' . $tag->getName() . $regexAttributes . '>';

        // Body
        $regexp .= '(.*)';

        // Tag closing
        $regexp .= '<\/' . $tag->getName() . '>';

        return '/' . $regexp . '/msU';
    }

    /**
     * Returns the MJML contents for a tag with given attributes
     *
     * @param  TagInterface $tag
     * @param  iterable     $match
     * @return string
     */
    private function toMJML(TagInterface $tag, iterable $match): string
    {

        $attributes = $tag->getAttributes();
        // $match[1] is attributes
        preg_match_all('/([a-z]+)="([a-zA-Z0-9#-]+)"/', $match[1], $matches, PREG_SET_ORDER);
        foreach ($matches as $attribute) {
            $key = $attribute[1];
            $value = $attribute[2];
            $attributes[$key] = $value;
        }

        // $match[2] is th body
        $body = $match[2];

        return $tag->getMJML($body, $attributes);
    }
}
