Installation
============

MJML command line tool
----------------------

```console
$ npm install --global mjml
```

This bundle
-----------

```console
$ composer require Assoconnect/mjml-bundle
```

How to use
==========

Creating custom HTML tag
------------------------

You need to create one PHP class per custom HTML tag.

Let's say you need to use a lot of red buttons with two sizes. With pure MJML you need to repeat the following code:

```html
<mj-button background-color="red" font-size="20px">Hello</mj-button>
<mj-button background-color="red" font-size="40px">Hello</mj-button>
```

Using this bundle, you just need
```html
<acme-button size="small">Hello</acme-button>
<acme-button size="big">Hello</acme-button>
```

Let's create the PHP class:

```php
<?php

declare(strict_types=1);

namespace App\MJML;

use Assoconnect\MJMLBundle\Tag\TagInterface;

class Button implements TagInterface
{
    public function getName(): string 
    {
        // Write here the name of the custom tag you are creating
        return 'acme-button';
    }
    
    public function getAttributes() : iterable{
        // List here the default attributes of your tag
        return [
            'size' => 'big'
        ];
    }
    
    public function getMJML(string $body,iterable $attributes): string
    {
        return <<<EOT
<mjml-button
    background-color="red"
    size="{$attributes['size']}"
 >{$body}</mjml-button>
EOT;
    }
}
```

Files' name and location
------------------------

Template files are expected to be into the `/templates/mjml` folder and must follow this naming pattern: `*.mjml.twig`.

HTML files are generated on Symfony cache warm-up and are in the same folder but named as `*.html.twig`.

Compile command
---------------

The bundle also provides a Symfony command to compile all or just one template:

```console
// Compiling all templates
php bin/console mjml:compiler

// Compiling just one template
php bin/console mjml:compiler --template=test.mjml.html
```

Debug
-----

The bundle processes the templates in two steps:
1. Parsing custom tags to MJML tags
2. Compiling MJML tags to HTML tags

During the first step, the bundle creates temporary files in the `%kernel.cache_dir%/assoconnect_mjml`. You may review their content with the [live editor](https://mjml.io/try-it-live) for debugging purpose. 
