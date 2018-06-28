# Categorizable 

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

It's a package to let you cagorize anything


## Install

Via Composer

``` bash
$ composer require unisharp/categorizable
```

## Usage

``` php
use UniSharp\Category\Categorizable;

class Post extends Model {
    use Categorizable;
}
```

### categorize

You can categorize by id, name or mixed array and id won't add duplicate category

``` php
$post->categorize(1); // by category id, it will do nothing if it can't find this category

$post->categorize("News"); // by category name and it will create new one if it can't find category

$post->categorize([1, "news"]); // You can use array

$post->categorize(1, "news"); // it's same as using array

```

### uncategorize

It will remove category just like categorize

``` php
$post->uncategorize(1);

$post->uncategorize("News");

$post->uncategorize([1, "news"]);

$post->uncategorize(1, "news");

```

### decategorize

remove all category

```php
$post->decategorize();

```

### recategorize

it will add category after clean all binding categories

same as $post->decategorize()->categorize(....)

```php
$post->recategorize(1);

$post->recategorize("News");

$post->recategorize([1, "news"]);

$post->recategorize(1, "news");

```

### hasCategories

You can find model which has specify categories
it also search all children category 

```php
Post::hasCategories('News', 1)->get();
```

### hasStrictCategories

It's same as hasCategories but just find category which you specify

```php
Post::hasStrictCategories('News', 1)->get();
```

You can find model which has specify categories
it also search all children category 

```php
Post::hasCategories('News', 1)->get();
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

If you discover any security related issues, please email xing1615@gmail.com instead of using the issue tracker.

## Credits

- [Xing][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/UniSharp/categorizable.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/UniSharp/categorizable/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/UniSharp/categorizable.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/UniSharp/categorizable.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/UniSharp/categorizable.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/unisharp/categorizable
[link-travis]: https://travis-ci.org/UniSharp/categorizable
[link-scrutinizer]: https://scrutinizer-ci.com/g/UniSharp/categorizable/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/UniSharp/categorizable
[link-downloads]: https://packagist.org/packages/UniSharp/categorizable
[link-author]: https://github.com/Nehemis1615
[link-contributors]: ../../contributors
