# forge

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![StyleCI](https://styleci.io/repos/109520799/shield?branch=master)](https://styleci.io/repos/109520799)
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]
[![StyleCI](https://styleci.io/repos/109520799/shield?branch=master)](https://styleci.io/repos/109520799)

Forge-publish is a Laravel 5 package provided by acacha thats provides you with artisan commands to easily install the 
current Laravel project into a Laravel Forge server.

## Install

``` bash
$ composer require acacha/forge-publish
```

## Usage

This package requires using https://forge.acacha.org. 

### Server side

Please first visit:

```
https://forge.acacha.org
```

Login and ask permissions to Manage a Laravel Forge Server. Wait to recibe a confirmation email 

### publish:init command

Run:

``` bash
php artisan publish:init
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email sergiturbadenas@gmail.com instead of using the issue tracker.

## Credits

- [Sergi Tur Badenas][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/acacha/forge.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/acacha/forge/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/acacha/forge.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/acacha/forge.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/acacha/forge.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/acacha/forge
[link-travis]: https://travis-ci.org/acacha/forge
[link-scrutinizer]: https://scrutinizer-ci.com/g/acacha/forge/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/acacha/forge
[link-downloads]: https://packagist.org/packages/acacha/forge
[link-author]: https://github.com/acacha
[link-contributors]: ../../contributors
