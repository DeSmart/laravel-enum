# PHP enums for Laravel models 📚

[![Latest version](https://img.shields.io/packagist/v/desmart/laravel-enum.svg?style=flat)](https://github.com/DeSmart/laravel-enum)
![Tests](https://github.com/desmart/laravel-enum/workflows/Run%20Tests/badge.svg)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg)](https://github.com/DeSmart/laravel-enum/blob/master/LICENSE)

Package provides a simple way to use strongly typed enum objects with Laravel models. It utilizes Laravel's custom
casting mechanism.

## Installation
To install the package via Composer, simply run the following command:

```bash
composer require desmart/laravel-enum
```

## Usage

Create an enum class that extends `DeSmart\Laravel\Enumeration`. Then, simply define all possible values in form of
class constants:

```php
class Character extends DeSmart\Laravel\Enumeration
{
    const GOOD = 'good';
    const EVIL = 'evil';
    const SOMETIMES_GOOD_SOMETIMES_EVIL = 'sometimes_good_sometimes_evil';
}
```

In Laravel model:

```php
class Hero extends Model
{
    /**
     * @var array
     */
    protected $casts = [
        'character' => Character::class,
    ];
}
```

That's it.

```php
$hero = new Hero(['character' => Character::EVIL]);

dump($hero);
// Hero {#293
//  ...
//  #casts: array:1 [
//    "character" => "Character"
//  ]
// ...
//  #attributes: array:1 [
//    "character" => "evil"
//  ]
// }

dump($hero->character);
// Character {#296
//  -value: "good"
// }
```
## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.