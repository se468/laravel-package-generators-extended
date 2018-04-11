# Laravel Package Generators Extended
[![Latest Stable Version](https://poser.pugx.org/se468/laravel-package-generators-extended/v/stable)](https://packagist.org/packages/se468/laravel-package-generators-extended)
[![Total Downloads](https://poser.pugx.org/se468/laravel-package-generators-extended/downloads)](https://packagist.org/packages/se468/laravel-package-generators-extended)
[![License](https://poser.pugx.org/se468/laravel-package-generators-extended/license)](https://packagist.org/packages/se468/laravel-package-generators-extended)

Adds Artisan command generators for the package for Commands, Migrations, Controllers, Models for rapid package development.

This package comes with useful generators:
```console
php artisan package:create

php artisan package:command

php artisan package:controller

php artisan package:migration

php artisan package:model
```

## Install
Via Composer
```console
$ composer require se468/laravel-package-generators-extended
```

## Usage


### Package
```console
$ package:create {vendor} {package} {namespace}
```

Will create a service provider and `composer.json` in your package src directory. 

It will also add the psr4 namespaces in your laravel's `composer.json` file and register the service provider in `config/app.php` automatically.

It's that simple!


### Optional Configuration
If you do not want to type vendor/package/namespace over and over for your generators, we offer a config file method. 

Publish the config file. 
```console
$ php artisan vendor:publish
```

It will generate `package-generators.php` in the `app/config` directory. You can modify `vendor`, `package`, `namespace` to set the default package. You may now call the commands without specifying vendor/package/namespaces, and just specify the name of the file you want to create.



### Command
```console
$ package:command {name_of_file} {vendor?} {package?} {namespace?} --path
```

Example:
```console
$ php artisan package:command TestCommand se468 test-package TestNamespace
```
or using config file
```console
$ php artisan package:command TestCommand
```

### Controller
```console
$ package:controller {name_of_file} {vendor?} {package?} {namespace?}  --path
```

Example:
```console
$ php artisan package:controller TestController se468 test-package TestNamespace
```
or using config file
```console
$ php artisan package:controller TestController
```


### Migration
```
$ package:migration {name_of_file} {vendor?} {package?} {namespace?} --path
```

Example:
```console
$ php artisan package:migration create_test_migration se468 test-package TestNamespace 
```
or using config file
```console
$ php artisan package:migration create_test_migration
```


### Model
```console
$ package:model {vendor} {package} {namespace} {name} --path
```

Example:
```console
$ php artisan package:model TestModel se468 test-package TestNamespace 
```
or using config file
```console
$ php artisan package:model TestModel
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
