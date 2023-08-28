# Very short description of the package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/igorkalm/idpcontroller.svg?style=flat-square)](https://packagist.org/packages/igorkalm/idpcontroller)
[![Total Downloads](https://img.shields.io/packagist/dt/igorkalm/idpcontroller.svg?style=flat-square)](https://packagist.org/packages/igorkalm/idpcontroller)
![GitHub Actions](https://github.com/igorkalm/idpcontroller/actions/workflows/main.yml/badge.svg)

An experimental package for Laravel 8 to use some features of IDP Access Controller manufactured by IDP Electronic ID Products Ltd (Israel). It's not intended for wide usage.

## Installation

You can install the package via composer:

```bash
composer require igorkalm/idpcontroller
```

## Usage

Add in config/app.php to "providers" section:
```php
Igorkalm\IDPcontroller\IDPcontrollerServiceProvider::class
```

Create new tables:
```php
php artisan migrate
```
If the feild named "qrcode" already exists in the users table, there will be an exception thrown. Just ignore it:

```php
**Illuminate\Database\QueryException**

SQLSTATE[42S21]: Column already exists: 1060 Duplicate column name 'qrcode' (SQL: alter table `users` add `qrcode` varchar(255) null)
at your-laravel-app\vendor\laravel\framework\src\Illuminate\Database\Connection.php:712
```
This field should contain a valid QR-code, similar to QR-code that is being sent by IDP Access Controller.

Add a record for at least one controller with its data where X-symbols should be replaced by appropriate real values:
```sql
INSERT INTO access_controllers(id,name,url,location) 
VALUES(1,'controller-name','http://XX.XX.XXX.XXX/command.html?pwd=XXXXXXX&command=','Where it is located');
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

### Security

If you discover any security related issues, please email ikalm@viscomp.ru instead of using the issue tracker.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This initial boilerplate code of this package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
