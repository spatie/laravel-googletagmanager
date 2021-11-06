# Google Tag Manager integration for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/laravel-googletagmanager.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-googletagmanager)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Quality Score](https://img.shields.io/scrutinizer/g/spatie/laravel-googletagmanager.svg?style=flat-square)](https://scrutinizer-ci.com/g/spatie/laravel-googletagmanager)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/laravel-googletagmanager.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-googletagmanager)

An easy [Google Tag Manager](http://www.google.com/tagmanager/) implementation for your Laravel 5 application.

Laravel 4 version: [spatie/laravel4-googletagmanager](https://github.com/spatie/laravel4-googletagmanager)

Spatie is a webdesign agency in Antwerp, Belgium. You'll find an overview of all our open source projects [on our website](https://spatie.be/opensource).

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/laravel-googletagmanager.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/laravel-googletagmanager)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Google Tag Manager

Google Tag Manager allows you manage tracking and marketing optimization with AdWords, Google Analytics, et al. without editing your site code. One way of using Google Tag Manager is by sending data through a `dataLayer` variable in javascript after the page load and on custom events. This package makes managing the data layer easy.

For concrete examples of what you want to send throught the data layer, check out Google Tag Manager's [Developer Guide](https://developers.google.com/tag-manager/devguide).

You'll also need a Google Tag Manager ID, which you can retrieve by [signing up](https://tagmanager.google.com/#/home) and creating an account for your website.

## Install

You can install the package via Composer:

```bash
composer require spatie/laravel-googletagmanager
```

In Laravel 5.5 and up, the package will automatically register the service provider and facade

In L5.4 or below start by registering the package's the service provider and facade:

```php
// config/app.php

'providers' => [
    ...
    Spatie\GoogleTagManager\GoogleTagManagerServiceProvider::class,
],

'aliases' => [
    ...
    'GoogleTagManager' => Spatie\GoogleTagManager\GoogleTagManagerFacade::class,
],
```

*The facade is optional, but the rest of this guide assumes you're using the facade.*

Next, publish the config files:

```bash
php artisan vendor:publish --provider="Spatie\GoogleTagManager\GoogleTagManagerServiceProvider" --tag="config"
```

Optionally publish the view files. It's **not** recommended to do this unless necessary so your views stay up-to-date in future package releases.

```bash
php artisan vendor:publish --provider="Spatie\GoogleTagManager\GoogleTagManagerServiceProvider" --tag="views"
```

If you plan on using the [flash-functionality](#flashing-data-for-the-next-request) you must install the GoogleTagManagerMiddleware, after the StartSession middleware:

```php
// app/Http/Kernel.php

protected $middleware = [
    ...
    \Illuminate\Session\Middleware\StartSession::class,
    \Spatie\GoogleTagManager\GoogleTagManagerMiddleware::class,
    ...
];
``` 

## Configuration

The configuration file is fairly simple.

```php
return [

    /*
     * The Google Tag Manager id, should be a code that looks something like "gtm-xxxx".
     */
    'id' => '',
    
    /*
     * Enable or disable script rendering. Useful for local development.
     */
    'enabled' => true,

    /*
     * If you want to use some macro's you 'll probably store them
     * in a dedicated file. You can optionally define the path
     * to that file here, and we will load it for you.
     */
    'macroPath' => '',

];

```

During development, you don't want to be sending data to your production's tag manager account, which is where `enabled` comes in.

Example setup:

```php
return [
    'id' => 'GTM-XXXXXX',
    'enabled' => env('APP_ENV') === 'production',
    'macroPath => app_path('Services/GoogleTagManager/Macros.php'),
];
```

## Usage

### Basic Example

First you'll need to include Google Tag Manager's script. Google's docs recommend doing this right after the body tag.

```
{{-- layout.blade.php --}}
<html>
  <head>
    @include('googletagmanager::head')
    {{-- ... --}}
  </head>
  <body>
    @include('googletagmanager::body')
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
  <head>
    <script>dataLayer = [{"pageType":"productDetail"}];</script>
    <script>/* Google Tag Manager's script */</script>
    <!-- ... -->
  </head>
  <!-- ... -->
</html>
```

#### Flashing data for the next request

The package can also set data to render on the next request. This is useful for setting data after an internal redirect.

```php
// ContactController.php

public function getContact()
{
    GoogleTagManager::set('pageType', 'contact');

    return view('contact');
}

public function postContact()
{
    // Do contact form stuff...

    GoogleTagManager::flash('formResponse', 'success');

    return redirect()->action('ContactController@getContact');
}
```

After a form submit, the following dataLayer will be parsed on the contact page:

```html
<html>
  <head>
    <script>dataLayer = [{"pageType":"contact","formResponse":"success"}];</script>
    <script>/* Google Tag Manager's script */</script>
    <!-- ... -->
  </head>
  <!-- ... -->
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

// Add data to the data layer (automatically renders right before the tag manager script). Setting new values merges them with the previous ones. Set also supports dot notation.
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
<a data-gtm-product='{!! GoogleTagManager::dump($product->toArray()) !!}' data-gtm-click>Product</a>
```

```js
$('[data-gtm-click]').on('click', function(event) {
    event.preventDefault();
    var self = this;
    dataLayer.push({
        'event': 'productClick',
        'ecommerce': {
            'click': {
                'products': $(self).data('gtm-product')
            }
        },
        'eventCallback': function() {
            document.location = $(self).attr('href');
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

In the configuration you can optionally set the path to the file that contains your macros.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email freek@spatie.be instead of using the issue tracker.

## Postcardware

You're free to use this package, but if it makes it to your production environment we highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using.

Our address is: Spatie, Kruikstraat 22, 2018 Antwerp, Belgium.

We publish all received postcards [on our company website](https://spatie.be/en/opensource/postcards).

## Credits

- [Sebastian De Deyne](https://github.com/sebastiandedeyne)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
