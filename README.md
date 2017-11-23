# Laravel Asset Version

[![Latest Version on Packagist](https://img.shields.io/packagist/v/elfsundae/laravel-asset-version.svg?style=flat-square)](https://packagist.org/packages/elfsundae/laravel-asset-version)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![StyleCI](https://styleci.io/repos/111650758/shield)](https://styleci.io/repos/111650758)

Laravel static assets versioning via query string: `app.js` → `app.js?d41d8cd98f`.

## Installation

```sh
$ composer require elfsundae/laravel-asset-version
```

For Lumen or earlier Laravel than v5.5, you need to register the service provider manually:

```php
ElfSundae\Laravel\AssetVersion\AssetVersionServiceProvider::class,
```

## Configuration

First you need to create an asset version configuration file located at `config/asset-version.php` , filled with assets paths. Or you may run the `asset-version:update` artisan command to create this file:

```php
<?php

return [
    'css/app.css',
    'js/app.js',
    'images/foo.png',
];
```

Then you can run the `asset-version:update` command to update the asset version configuration:

```sh
$ php artisan asset-version:update
```

Now the configuration file might be:

```php
<?php

return array (
  'css/app.css' => '3ede8f2085',
  'js/app.js' => '2eaf111399',
  'images/foo.png' => 'd41d8cd98f',
);
```

:warning: **You need to run the `asset-version:update` command every time you changed any asset content.** You may call this command in your assets build script, e.g. [Laravel Elixir](https://laravel.com/docs/5.3/elixir):

```diff
elixir((mix) => {
    mix
    .sass('app.scss')
    .webpack('app.js')
    .exec('php artisan asset-version:update');
});
```

## Usage

You can get the versioned asset path using the `asset_path()` helper function:

```php
asset_path('css/app.css');  // "/css/app.css?3ede8f2085"

<link href="{{ asset_path('js/app.js') }}" rel="stylesheet">
```

## License

This package is open-sourced software licensed under the [MIT License](LICENSE.md).
