Installation
============

MJML command line tool
----------------------

```console
npm install --global mjml
```

This bundle
-----------

```console
composer require Assoconnect/mjml-bundle
```

How to use
==========

Creating a custom HTML tag
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
    
    public function getMJML(string $body, iterable $attributes): string
    {
        if($attributes['size'] === 'big') {
	    $height = 200;
	} else {
	    $height = 100;
	}
        return <<<EOT
<mj-button
    background-color="red"
    height="{$height}px"
 >{$body}</mj-button>
EOT;
    }
}
```

Files' name and location
------------------------

Template files are expected to be into the `/templates/mjml` folder and must follow this naming pattern: `*.mjml.twig`.

HTML files are generated on Symfony cache warm-up and are in the same folder but named as `*.html.twig`.

This files should not be commited to your GIT repository: ignore them with this rule `/template/mjml/*.html.twig` in `/.gitignore` file.
If you are using Symfony 4, you do not need to create this rule as this bundle comes with a recipe that takes care of it.

Compile command
---------------

The bundle also provides a Symfony command to compile all or just one template:

```console
// Compiling all templates
php bin/console mjml:compiler

// Compiling just one template
php bin/console mjml:compiler test.mjml.html
```

Using it with Twig
------------------

You can now use this template with Twig:

```html
<mjml>
  <mj-body>
    <mj-section>
      <mj-column>

        <mj-text font-size="20px" color="#F45E43" font-family="helvetica">Hello World</mj-text>
		
		<acme-button>Click me!</acme-button>

      </mj-column>
    </mj-section>
  </mj-body>
</mjml>
```

```php
<?php
# src/Service/EmailerService.php
namespace App\Service;

use Twig\Environment;

class EmailerService
{
	protected $twig;
	
	public function __construct(Environment $twig)
	{
		$this->twig = $twig;
	}
	
	public function sendEmail()
	{
		$templateFile = 'mjml/my_template.html.twig';
		
		$template = $this->twig->load($templateFile);
		
		$html = $template->render([
			// place here the variables to resolve in your template
			'firstname' => 'John',
		]);
		
		// implement here your email sending logic
		// $html contains the HTML to use as email body
	}
}
```

Debug
-----

The bundle processes the templates in two steps:
1. Parsing custom tags to MJML tags
2. Compiling MJML tags to HTML tags

During the first step, the bundle creates temporary files in the `%kernel.cache_dir%/assoconnect_mjml`. You may review their content with the [live editor](https://mjml.io/try-it-live) for debugging purpose. 
