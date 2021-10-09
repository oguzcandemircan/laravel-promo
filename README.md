# Laravel promo generator

[![Latest Version on Packagist](https://img.shields.io/packagist/v/oguzcandemircan/laravel-promo.svg?style=flat-square)](https://packagist.org/packages/oguzcandemircan/laravel-promo)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/oguzcandemircan/laravel-promo/run-tests?label=tests)](https://github.com/oguzcandemircan/laravel-promo/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/oguzcandemircan/laravel-promo/Check%20&%20fix%20styling?label=code%20style)](https://github.com/oguzcandemircan/laravel-promo/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/oguzcandemircan/laravel-promo.svg?style=flat-square)](https://packagist.org/packages/oguzcandemircan/laravel-promo)

---
This repo can be used to scaffold a Laravel package. Follow these steps to get started:

1. Press the "Use template" button at the top of this repo to create a new repo with the contents of this laravel-promo
2. Run "./configure-laravel-promo.sh" to run a script that will replace all placeholders throughout all the files
3. Remove this block of text.
4. Have fun creating your package.
5. If you need help creating a package, consider picking up our <a href="https://laravelpackage.training">Laravel Package Training</a> video course.
---

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/laravel-promo.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/laravel-promo)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the package via composer:

```bash
composer require oguzcandemircan/laravel-promo
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --provider="OguzcanDemircan\LaravelPromo\LaravelPromoServiceProvider" --tag="laravel-promo-migrations"
php artisan migrate
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="OguzcanDemircan\LaravelPromo\LaravelPromoServiceProvider" --tag="laravel-promo-config"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

```php
$laravel-promo = new OguzcanDemircan\LaravelPromo();
echo $laravel-promo->echoPhrase('Hello, Spatie!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Oğuzcan Demircan](https://github.com/oguzcandemircan)
- [All Contributors](../../contributors)
- I was inspired by the [laravel-promocodes](https://github.com/zgabievi/laravel-promocodes) and [laravel-vouchers](https://github.com/beyondcode/laravel-vouchers) packages

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
