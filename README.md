# Google Tag Manager integration for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/laravel-googletagmanager.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-googletagmanager)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Quality Score](https://img.shields.io/scrutinizer/g/spatie/laravel-googletagmanager.svg?style=flat-square)](https://scrutinizer-ci.com/g/spatie/laravel-googletagmanager)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/46932ea6-5df3-4dca-8342-461b4d3db3a7.svg?style=flat-square)](https://insight.sensiolabs.com/projects/46932ea6-5df3-4dca-8342-461b4d3db3a7)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/laravel-googletagmanager.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-googletagmanager)

An easy [Google Tag Manager](http://www.google.com/tagmanager/) implementation for your Laravel application. This package supports Laravel 4 & Laravel 5.

## Google Tag Manager

Google Tag Manager allows you manage tracking and marketing optimization with AdWords, Google Analytics, et al. without editing your site code. One way of using Google Tag Manager is by sending data through a `dataLayer` variable in javascript after the page load and on custom events. This package makes managing the data layer easy.

For concrete examples of what you want to send throught the data layer, check out Google Tag Manager's [Developer Guide](https://developers.google.com/tag-manager/devguide).

You'll also need a Google Tag Manager ID, which you can retrieve by [signing up](https://tagmanager.google.com/#/home) and creating an account for your website.

## Install

You can install the package via Composer:

```bash
$ composer require spatie/laravel-googletagmanager
```

Start by registering the package's the service provider and facade:

```php
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

*The facade is optional, but the rest of this guide assumes you're using the facade.*

Next, publish the config files:

```bash
// L5
$ php artisan vendor:publish --provider="Spatie\GoogleTagManager\GoogleTagManagerServiceProvider" --tag="config"

// L4
$ php artisan config:publish spatie/googletagmanager --path="vendor/spatie/laravel-googletagmanager/resources/config"
```

Optionally publish the view files. It's **not** recommended to do this unless necessary so your views stay up-to-date in future package releases.

```bash
// L5
$ php artisan vendor:publish --provider="Spatie\GoogleTagManager\GoogleTagManagerServiceProvider" --tag="views"

// L4
$ php artisan views:publish spatie/googletagmanager --path="vendor/spatie/laravel-googletagmanager/resources/views"
```

## Configuration

The configuration file is fairly simple.

```php
return [
    'id' => '',
    'enabled' => true,
];
```

During development, you don't want to be sending data to your production's tag manager account, which is where `enabled` comes in.

Example setup:

```php
return [
    'id' => 'GTM-XXXXXX',
    'enabled' => app()->environment() === 'production',
];
```

## Usage

### Basic Example

First you'll need to include Google Tag Manager's script. Google's docs recommend doing this right after the body tag.

```
{{-- layout.blade.php --}}
<html>
  {{-- ... --}}
  <body>
    @include('googletagmanager::script')
    {{-- ... --}}
  </body>
</html>
```

Your base dataLayer will also be rendered here. To add data, use the `set()` function. 

```php
// HomeController.php

public function index()
{
    GoogleTagManager::set('pageType', 'productDetail');

    return view('home');
}
```

This renders: 

```html
<html>
  <!-- ... -->
  <body>
    <script>dataLayer = [{"pageType":"productDetail"}];</script>
    <script>/* Google Tag Manager's script */</script>
    <!-- ... -->
  </body>
</html>
```

### Other Simple Methods

```php
// Retrieve your Google Tag Manager id
$id = GoogleTagManager::id(); // GTM-XXXXXX

// Check whether script rendering is enabled
$enabled = GoogleTagManager::isEnabled(); // true|false

// Enable and disable script rendering
GoogleTagManager::enable();
GoogleTagManager::disable();

// Add data to the data layer (automatically renders right before the tag manager script). Setting new values merges them with the previous ones. Set als supports dot notation.
GoogleTagManager::set(['foo' => 'bar']);
GoogleTagManager::set('baz', ['ho' => 'dor']);
GoogleTagManager::set('baz.ho', 'doorrrrr');

// [
//   'foo' => 'bar',
//   'baz' => ['ho' => 'doorrrrr']
// ]
```

### Dump

GoogleTagManager also has a `dump()` function to convert arrays to json objects on the fly. This is useful for sending data to the view that you want to use at a later time.

```
<a data-gtm-product='{!! GoogleTagManager::dump($article->toArray()) !!}' data-gtm-click>Product</a>
```

```js
$('[data-gtm-click]').on('click', function() {
    dataLayer.push({
        'event': 'productClick',
        'ecommerce': {
            'click': {
                'products': $(this).data('gtm-product')
            }
        }
        'eventCallback': function() {
            document.location = $(this).attr('href');
        }
    });
});
```

### DataLayer

Internally GoogleTagManager uses the DataLayer class to hold and render data. This class is perfectly usable without the rest of the package for some custom implementations. DataLayer is a glorified array that has dot notation support and easily renders to json.

```php
$dataLayer = new Spatie\GoogleTagManager\DataLayer();
$dataLayer->set('ecommerce.click.products', $products->toJson());
echo $dataLayer->toJson(); // {"ecommerce":{"click":{"products":"..."}}}
```

If you want full access to the GoogleTagManager instances' data layer, call the `getDataLayer()` function.

```php
$dataLayer = GoogleTagManager::getDataLayer();
```

### Macroable

Adding tags to pages can become a repetitive process. Since this package isn't supposed to be opinionated on what your tags should look like, the GoogleTagManager is macroable.

```php
GoogleTagManager::macro('impression', function ($product) {
    GoogleTagManager::set('ecommerce', [
        'currencyCode' => 'EUR',
        'detail' => [
            'products' => [ $product->getGoogleTagManagerData() ]
        ]
    ]);
});

GoogleTagManager::impression($product);
```

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
