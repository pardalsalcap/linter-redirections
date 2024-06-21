# Add on to manage 404 and redirections into linter and filament

[![Latest Version on Packagist](https://img.shields.io/packagist/v/pardalsalcap/linter-redirections.svg?style=flat-square)](https://packagist.org/packages/pardalsalcap/linter-redirections)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/pardalsalcap/linter-redirections/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/pardalsalcap/linter-redirections/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/pardalsalcap/linter-redirections/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/pardalsalcap/linter-redirections/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/pardalsalcap/linter-redirections.svg?style=flat-square)](https://packagist.org/packages/pardalsalcap/linter-redirections)

This package is and add on to the linter panel to manage 404 and redirections. It includes a filament resource for managng and redirecting 404 and 2 widgets for the dashboard to get the information of the 404 and redirections.

## Installation

You can install the package via composer:

```bash
composer require pardalsalcap/linter-redirections
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="linter-redirections-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="linter-redirections-config"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

To register the 404 or any Exception you like to monitor you can add the following code to your `app/Exceptions/Handler.php` file:

```php
use Pardalsalcap\HialoRedirections\Repositories\RedirectionRepository;

public function render($request, Throwable $e) {
    switch(class_basename($e)){
        case 'NotFoundHttpException':
            $http_status = $e->getStatusCode();

            $redirection_repository = new RedirectionRepository();
            $redirection = $redirection_repository->check(request()->fullUrl());
            if ($redirection) {
                return redirect($redirection->fix, $redirection->http_status);
            }

            if ($http_status == "404")
            {
                $redirection_repository->logError(request()->fullUrl(), $http_status);
            }
        break;
    }
    return parent::render($request, $e); 
}
```

If you want to log any other exception you can add it to the switch case.

## Resources

You can extend the RedirecionsResource to add the ability to manage the redirections from the filament panel. 
To do so you can create a Resource like this:

```php
<?php

namespace App\Filament\Resources;

class RedirectionResource extends \Pardalsalcap\LinterRedirections\Resources\RedirectionResource
{
   // Any additional logic here
}

```

## Widgets

To add the widgets to the dashboard you can add the following code to your filament panel widgets section:

```php  
    RedirectionsStats::class,
    RedirectionsDashboardWidget::class,
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.


## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [pardalsalcap](https://github.com/pardalsalcap)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
