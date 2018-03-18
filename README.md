# Video Server

Symfony 1.4 video uploading server

## Installation

Set up models and create table in DB:
```php
$ php symfony propel:build --model
$ php symfony propel:build --forms
$ php symfony propel:build --filters
$ php symfony propel:build --sql
$ php symfony propel:insert-sql
```

Load initial data:
```php
$ php symfony propel:data-load
```

Or do it in another way:
```php
$ php symfony propel:build --all --and-load --no-confirmation
```

Enable plugins in `ProjectConfiguration.class.php` like this:

```php
    public function setup()
    {
        $this->enablePlugins('sfPropelPlugin');
        $this->enablePlugins('isoOptimizerPlugin');
        $this->enablePlugins('isoCommonPartialPlugin');
    }
```

Run `consumer.php`
```php
$ php consumer.php
```

## Requirements

* [PHP 7.1](http://php.net/) - language

## Built With

* [Symfony 1.4](http://symfony.com/legacy) - web framework
* [RabbitMQ](https://www.rabbitmq.com/) - message broker

## License

This project is licensed under the GNU License - see the [LICENSE.md](LICENSE.md) file for details
