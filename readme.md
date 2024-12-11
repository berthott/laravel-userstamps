![test workflow](https://github.com/berthott/laravel-userstamps/actions/workflows/test.yml/badge.svg)

# Laravel-Userstamps

A helper to maintain Userstamps in Laravel. 
Easily add and maintain userstamps by adding a trait to your model.

## Installation

```sh
$ composer require berthott/laravel-userstamps
```

## Usage

* Create your table and corresponding model, eg. with `php artisan make:model YourModel -m`
* Add `$table->userstamps()` to your migration
  * If you use the `SoftDeletes` trait on your model additionally add `$table->softDeletesUserstamp()`
* Add the `HasUserstamps` trait to your newly generated model.
* For some more macros see `\berthott\Userstamps\UserstampsServiceProvider::register()`
* `creator()`, `editor()`, and `destroyer()` will be available for your convenience.

## Options

You may change the column names by adding these constants to your model. 
```php
const CREATED_BY = 'alt_created_by';
const UPDATED_BY = 'alt_updated_by';
const DELETED_BY = 'alt_deleted_by';
```

Note that in this case you cannot use `$table->userstamps()` but need to define the columns separately with 
```php
$table->unsignedBigInteger('alt_created_by')->nullable();
$table->unsignedBigInteger('alt_updated_by')->nullable();
$table->unsignedBigInteger('alt_deleted_by')->nullable();
```

## Compatibility

Tested with Laravel 10.x.

## Credits

Inspired by https://github.com/WildsideUK/Laravel-Userstamps and https://github.com/hrshadhin/laravel-userstamps.

## License

See [License File](license.md). Copyright © 2023 Jan Bladt.