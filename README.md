# Laravel Blade Anchor

[![Latest Version on Packagist](https://img.shields.io/packagist/v/kanuni/laravel-blade-anchor.svg?style=flat-square)](https://packagist.org/packages/kanuni/laravel-blade-anchor)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/kanuni/laravel-blade-anchor/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/kanuni/laravel-blade-anchor/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/kanuni/laravel-blade-anchor/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/kanuni/laravel-blade-anchor/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/kanuni/laravel-blade-anchor.svg?style=flat-square)](https://packagist.org/packages/kanuni/laravel-blade-anchor)

Easily enable extending your application's user interface by third-party packages with anchors.

## Installation

You can install the package via composer:

```bash
composer require kanuni/laravel-blade-anchor
```

## Usage

To enable extending your application UI you first need to place anchors on places in your blade template files where you want to allow third-party to extend your UI.

### Place anchor(s) to enable extending your application UI

Somewhere in your blade file, for example in `resources/views/welcome.blade.php` add anchor directive. In this demo we will create an anchor right after opening `<body>` tag:

```
...
<body>
    @anchor('begin.body')
    ...
</body>
```

Name of the anchor can be anything you want. In this example we assigned name `begin.body`.

### Creating extender class

After we have placed our anchor we can register extender class to render some string or Laravel View at that anchor point. The best place to register your anchor extenders would be in the `boot()` method of your AppServiceProvider class. But first, let's create a new anchor extender class with artisan command:

```
php artisan make:anchor-extender WelcomePageExtender
```

That command will create new extender class in `app/BladeExtenders/WelcomePageExtender.php`. This is a simple class that implements `__invoke()` method. Results of that method will be rendered at anchor point.

Example of our newly created class:

```php
namespace App\BladeExtenders;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\Support\Renderable;
use Kanuni\LaravelBladeAnchor\Contracts\AnchorExtender;

class WelcomePageExtender implements AnchorExtender
{
    public function __invoke(?array $variables): string|Htmlable|Renderable
    {
        return '<p>This string will be injected at anchor point.</p>';
    }
}
```

As you can see, `__invoke()` method must return string or View. Also this function accepts array of available variables in your blade template. If you are returning blade view from `__invoke()` method you can pass the variables to your view like this:

```php
public function __invoke(?array $variables): string|Htmlable|Renderable
{
    return view('my-custom-blade-view', $variables);
}
```

You can also resolve any service class in extender `__construct()` method:

```php
class WelcomePageExtender implements AnchorExtender
{
    public function __construct(
        protected YourService $service
    ) {}

    public function __invoke(?array $variables): string|Htmlable|Renderable
    {
        return "<p>This are the results of your service: {$this->service->getResults()}</p>";
    }
}
```

### Attach extender to the anchor

Register your Blade extender in the `boot()` method of `app/Providers/AppServiceProvider` class using  `LaravelBladeAnchor` facade. To register the extender you have to call `registerExtender` method and provide view name, anchor name and extender class.

```php
use Kanuni\LaravelBladeAnchor\Facades\LaravelBladeAnchor;

public function boot(): void
{
    LaravelBladeAnchor::registerExtender(
        view: 'welcome',
        anchor: 'begin.body',
        extenderClass: WelcomePageExtender::class,
    );
}
```

That is it.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Zvonimir Lokmer](https://github.com/tjodalv)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
