# Laravel-Userstamps - A helper to maintain Userstamps in Laravel

Easily add and maintain userstamps by adding a trait to your model.

## Installation

```
$ composer require berthott/laravel-userstamps
```

## Usage

* Create your table and corresponding model, eg. with `php artisan make:model YourModel -m`
* Add `$table->userstamps()` to you migration
* Add the `Userstamps` Trait to your newly generated model.

## Options

To change the default options use
```
$ php artisan vendor:publish --provider="berthott\Crudable\CrudableServiceProvider" --tag="config"
```
* `middleware`: an array of middlewares that will be added to the generated routes
* `namespace`: string or array with one ore multiple namespaces that should be monitored for the Crudable-Trait. Defaults to `App\Models`.
* `prefix`: route prefix. Defaults to `api`

## Compatibility

Tested with Laravel 8.x.

## License

See [License File](license.md). Copyright © 2021 Jan Bladt.