# Lunar API

[![Latest Version on Packagist](https://img.shields.io/packagist/v/dystcz/lunar-api.svg?style=flat-square)](https://packagist.org/packages/dystcz/lunar-api)
[![Total Downloads](https://img.shields.io/packagist/dt/dystcz/lunar-api.svg?style=flat-square)](https://packagist.org/packages/dystcz/lunar-api)
![GitHub Actions](https://github.com/dystcz/lunar-api/actions/workflows/tests.yaml/badge.svg)

This package introduces an API layer for Lunar ecommerce package.

## Installation

You can install the package via composer:

```bash
composer require dystcz/lunar-api
```

Publish config and migrations, run migrations

```bash
php artisan vendor:publish --provider="Dystcz\LunarApi\LunarApiServiceProvider" --tag="config"
```

## Usage

```php
// Usage description here
```

### Todo list

- [ ] Create documentation
- [ ] Create and register policies for each resource and each resource method ideally

### Useful resource

- `laravel-json-api` stubs [https://github.com/laravel-json-api/laravel/tree/develop/stubs](https://github.com/laravel-json-api/laravel/tree/develop/stubs)

### Testing

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email jakub@dy.st instead of using the issue tracker.

## Credits

-   [Jakub Theimer](https://github.com/dystcz)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

