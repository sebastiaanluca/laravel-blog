# laravel-blog

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

A simple-to-use blog system you can pull into any existing Laravel project and immediately get writing.

## Install

Via Composer

``` bash
$ composer require sebastiaanluca/laravel-blog
```

## Usage

- User model
- At least one active user
- Publish assets, etc

```
SebastiaanLuca\Router\RouterServiceProvider::class, + instructions on how to extend kernel
SebastiaanLuca\Helpers\Html\HtmlServiceProvider::class,
GrahamCampbell\Markdown\MarkdownServiceProvider::class,
```

```
'Form' => Collective\Html\FormFacade::class,
'Html' => Collective\Html\HtmlFacade::class,
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email hello@sebastiaanluca.com instead of using the issue tracker.

## Credits

- [Sebastiaan Luca][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/sebastiaanluca/laravel-blog.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/sebastiaanluca/laravel-blog/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/sebastiaanluca/laravel-blog.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/sebastiaanluca/laravel-blog.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/sebastiaanluca/laravel-blog.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/sebastiaanluca/laravel-blog
[link-travis]: https://travis-ci.org/sebastiaanluca/laravel-blog
[link-scrutinizer]: https://scrutinizer-ci.com/g/sebastiaanluca/laravel-blog/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/sebastiaanluca/laravel-blog
[link-downloads]: https://packagist.org/packages/sebastiaanluca/laravel-blog
[link-author]: https://github.com/sebastiaanluca
[link-contributors]: ../../contributors
