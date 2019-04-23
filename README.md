# AssoconnectMJMLBundle

[![Build Status](https://travis-ci.org/assoconnect/mjml-bundle.svg?branch=master)](https://travis-ci.org/assoconnect/mjml-bundle)
[![Coverage Status](https://coveralls.io/repos/github/assoconnect/mjml-bundle/badge.svg?branch=master)](https://coveralls.io/github/assoconnect/mjml-bundle?branch=master)

This Symfony 4 bundle provides the integration of the [MJML command line tool](https://mjml.io/documentation/#command-line-interface) to create responsive emails as Twig templates.

It requires the installation of the MJML command line tools running with NodeJS.

It also supports custom HTML tags to avoid duplicating long MJML tags with a lot of options to ensure consistency amongst your templates.

Twig expressions can be used within the templates.

As compiling MJML code to HTML code is slow, this bundle follows this process:
- you write MJML templates with Twig expressions
- during cache warmup, these templates are compiled to HTML and Twig expressions are not resolved
- you use the compiled HTML templates with Twig and all the variables you need with you favorite email sending system

[How to use](src/Resources/doc/index.md) 