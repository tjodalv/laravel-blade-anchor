# Laravel Blade Anchor ⚓

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

To allow third-party packages to extend your application's UI, you need to insert anchors into your Blade template files at the points where you want to permit these extensions.

### Placing anchors to enable UI extensions

In your Blade file (e.g., `resources/views/welcome.blade.php`), you can add an anchor directive. For this example, let's create an anchor immediately after the opening `<body>` tag:

```
...
<body>
    @anchor('begin.body')
    ...
</body>
```

You can name the anchor anything you like. In this example, we've named it `begin.body`.

### Creating an extender class

Once you've positioned your anchor, you can now register an extender class that will render a string or a Laravel View at that anchor point. Ideally, you should register your anchor extenders in the `boot()` method of your `AppServiceProvider` class.

But first, let's create a new anchor extender class using the Artisan command:

```
php artisan make:anchor-extender WelcomePageExtender
```

This command generates a new extender class in `app/BladeExtenders/WelcomePageExtender.php`. This class should implement the `__invoke()` method, whose return value will be rendered at the specified anchor point.

Here's an example of our newly created class:

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

The `__invoke()` method can return a string or a View and accepts an optional array of variables available in your Blade template. If returning a Blade view, you can pass the variables to your view like this:

```php
public function __invoke(?array $variables): string|Htmlable|Renderable
{
    return view('my-custom-blade-view', $variables);
}
```

It's also possible to inject any dependency classes into your extender's `__construct()` method:

```php
class WelcomePageExtender implements AnchorExtender
{
    public function __construct(
        protected YourService $service
    )
    {}

    public function __invoke(?array $variables): string|Htmlable|Renderable
    {
        return "<p>This are the results of your service: {$this->service->getResults()}</p>";
    }
}
```

### Attaching the Extender to the Anchor

Register your Blade extender in the `boot()` method of `app/Providers/AppServiceProvider` class using  `LaravelBladeAnchor` facade. To do this, call the `registerExtender` method and provide the view name, anchor name, and extender class.

```php
use Kanuni\LaravelBladeAnchor\Facades\LaravelBladeAnchor;
use App\BladeExtenders\WelcomePageExtender;

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
