# Laravel-Userstamps - A helper to maintain Userstamps in Laravel

Easily add and maintain userstamps by adding a trait to your model.

## Installation

```
$ composer require berthott/laravel-userstamps
```

## Usage

* Create your table and corresponding model, eg. with `php artisan make:model YourModel -m`
* Add `$table->userstamps()` to you migration
  * Additionaly you must add `$table->softDeletesUserstamp()` when you use the `SoftDeletes` trait on your model
* Add the `Userstamps` trait to your newly generated model.

## Options

You may change the column names by setting
```
const CREATED_BY = 'alt_created_by';
const UPDATED_BY = 'alt_updated_by';
const DELETED_BY = 'alt_deleted_by';
```
Note that you cannot use `$table->userstamps()` but need to define the columns seperately with 
```
$table->unsignedBigInteger('alt_created_by')->nullable();
$table->unsignedBigInteger('alt_updated_by')->nullable();
$table->unsignedBigInteger('alt_deleted_by')->nullable();
```

## Compatibility

Tested with Laravel 8.x.

## Credits

Inspired by https://github.com/WildsideUK/Laravel-Userstamps and https://github.com/hrshadhin/laravel-userstamps.

## License

See [License File](license.md). Copyright © 2021 Jan Bladt.