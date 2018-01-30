# Database bundle

A Symfony bundle with useful database stuff.

## Installation

Require the bundle with composer:

```sh
composer require itk-dev/database-bundle "^1.0"
```

Enable the bundle in the kernel:

```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = [
        // …
        new ItkDev\DatabaseBundle(),
        // …
    ];
}
```

## Usage

Dump database:

```sh
bin/console itk-dev:database:dump
```

Open database from command line:

```sh
bin/console itk-dev:database:cli
```
