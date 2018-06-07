# Database bundle

A Symfony bundle with useful database stuff.

## Installation

Require the bundle with `composer`:

```sh
composer require itk-dev/database-bundle "^1.1"
```

Enable the bundle:

```php
<?php
// Symfony 2 and 3.
// app/AppKernel.php

public function registerBundles()
{
    $bundles = [
        // …
        new ItkDev\DatabaseBundle\ItkDevDatabaseBundle(),
        // …
    ];
}
```

```php
<?php
// Symfony 4.
// config/bundles.php

return [
    // …
    ItkDev\DatabaseBundle\ItkDevDatabaseBundle::class => ['all' => true],
    // …
];

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
