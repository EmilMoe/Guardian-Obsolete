# Guardian

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

Guardian is a framework for handling roles and permissions in Laravel. As SaaS and management web application are being more and more popular, it's essential to make the flow of the permissions as simple as possible, so you can focus on making the product.

Therefor I made this package which will enable you to define permissions in middleware. Not only does this allow you to separate the logic from your application it also allows you to perform ``php artisan route:list`` to see which part of your application is restricted by which permission.

## Requirements

Guardian requires **Laravel 5.1** in order to work due to it's use of middleware parameters. Other requirements are defined by [Laravel 5.1](https://laravel.com/docs/5.1).

## Installation

The easiest way to install Guardian is to use composer. Run this composer in your shell to begin installation

~~~~shell
composer require emilmoe/guardian
~~~~

After the package has successfully been installed to your application, you must set up a service provider in ``config\app.php``:

~~~~php
EmilMoe\Guardian\GuardianServiceProvider::class,
~~~~

Publish the migrations and configuration files to your application by executing this command in your shell:

~~~~shell
php artisan vendor:publish --provider="EmilMoe\GuardianServiceProvider"
~~~~

Please take a look through the config fil in ``config\guardian.php`` as some configurations must be set before you migrate the package. The configurations is sefl explainable.

Last step is to migrate 4 tables to your database. Guardian currently only supports application with an database, the tables are used to keep track of roles, permissions and how they are related between and with your application.

Run the migration by executing this in your shell:

~~~~shell
php artisan migrate
~~~~
In your user model, which by default is ``App\User.php`` you must add this trait:

~~~~php
use WithPermission;
~~~~

Read more about the traits in the trait section, but it's essential for Guardian to work.

## Usage

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

Coming

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email emil@moegroup.dk instead of using the issue tracker.

## Credits

- [Emil Moe][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/EmilMoe/Guardian.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/EmilMoe/Guardian/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/EmilMoe/Guardian.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/EmilMoe/Guardian.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/EmilMoe/Guardian.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/EmilMoe/Guardian
[link-travis]: https://travis-ci.org/EmilMoe/Guardian
[link-scrutinizer]: https://scrutinizer-ci.com/g/EmilMoe/Guardian/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/EmilMoe/Guardian
[link-downloads]: https://packagist.org/packages/EmilMoe/Guardian
[link-author]: https://github.com/emilmoe
[link-contributors]: ../../contributors
