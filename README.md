# Video Server

Symfony 1.4 video uploading server

## Installation

Set up models and create table in DB:
```php
$ php symfony propel:build --model
$ php symfony propel:build --sql
$ php symfony propel:insert-sql
```

Load initial data:
```php
$ php symfony propel:data-load
```

## Requirements

* [PHP 7.1](http://php.net/) - language

## Built With

* [Symfony 1.4](http://symfony.com/legacy) - web framework

## License

This project is licensed under the GNU License - see the [LICENSE.md](LICENSE.md) file for details