# Laravel Package Generators Extended
Adds Artisan command generators for the package for Commands, Migrations, Controllers, Models for rapid package development.

## Install
Via Composer
``` bash
$ composer require se468/laravel-package-generators-extended
```

## Usage

**Package**
```
package:create {vendor} {package} {namespace}
```

Will create a service provider and `composer.json` in your package src directory. You must then add namespace in Laravel `composer.json` and service provider in `config/app.php`.

**Command**
```
package:command {name_of_file} {vendor?} {package?} {namespace?} --path
```

Example:
```
$ php artisan package:command TestCommand se468 test-package TestNamespace
```

**Controller**
```
package:controller {name_of_file} {vendor?} {package?} {namespace?}  --path
```

Example:
```
$ php artisan package:controller TestController se468 test-package TestNamespace
```

**Migration**
```
package:migration {name_of_file} {vendor?} {package?} {namespace?} --path
```

Example:
```
$ php artisan package:migration create_test_migration se468 test-package TestNamespace 
```

**Model**
```
package:model {vendor} {package} {namespace} {name} --path
```

Example:
```
$ php artisan package:model TestModel se468 test-package TestNamespace 
```


**Optional Configuration**
If you do not want to type vendor/package/namespace over and over for your generators, we offer a config file method. 

Publish the config file. 
```
php artisan vendor:publish

and select this package.
```

It will generate `package-generators.php` in the `app/config` directory. You can modify `vendor`, `package`, `namespace` to set the default package. You may now call the commands without the vendor/package/namespaces, and just specify the name of the file you want to create.

For example:
```
php artisan package:model TestModel
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
