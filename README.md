# Google Tag Manager integration for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/laravel-googletagmanager.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-googletagmanager)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Quality Score](https://img.shields.io/scrutinizer/g/spatie/laravel-googletagmanager.svg?style=flat-square)](https://scrutinizer-ci.com/g/spatie/laravel-googletagmanager)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/laravel-googletagmanager.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-googletagmanager)

An Easy [Google Tag Manager](http://www.google.com/tagmanager/) implementation for your Laravel application. Supports Laravel 4 & 5.

## Install

You can install the package via Composer:

``` bash
$ composer require spatie/laravel-googletagmanager
```

Register the service provider and facade:

``` php
// config/app.php (L5) or app/config/app.php (L4)

'providers' => [
  ...
  'Spatie\GoogleTagManager\GoogleTagManagerServiceProvider',
],

'aliases' => [
  ...
  'GoogleTagManager' => 'Spatie\GoogleTagManager\GoogleTagManagerFacade',
],

```

Publish the config files:

``` bash
// L5
$ php artisan vendor:publish --provider="Spatie\GoogleTagManager\GoogleTagManagerServiceProvider" --tag="config"

// L4
$ php artisan config:publish spatie/googletagmanager --path="vendor/spatie/laravel-googletagmanager/resources"
```

Optionally publish the view files (it's recommended not to do this if you don't need to edit them for easier package updates)

``` bash
// L5
$ php artisan vendor:publish --provider="Spatie\GoogleTagManager\GoogleTagManagerServiceProvider" --tag="views"

// L4
$ php artisan views:publish spatie/googletagmanager --path="vendor/spatie/laravel-googletagmanager/resources"
```

## Setup

...

## Usage

...

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email freek@spatie.be instead of using the issue tracker.

## Credits

- [Sebastian De Deyne](https://github.com/sebastiandedeyne)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
