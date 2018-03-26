# Laravel Package Generators Extended
Adds Artisan command generators for the package for Commands, Migrations, Controllers, Models for rapid package development.

## Install
Via Composer
``` bash
$ composer require se468/laravel-package-generators-extended
```

## Usage
**Command**
```
package:command {vendor} {package} {namespace} {name} --path
```

Example:
```
package:command se468 laravel-package-generators-extended LaravelPackageGeneratorsExtended TestCommand
```

**Controller**
```
package:controller {vendor} {package} {namespace} {name} --path
```

Example:
```
package:controller se468 laravel-package-generators-extended LaravelPackageGeneratorsExtended TestController
```

**Migration**
```
package:migration {vendor} {package} {namespace} {name} --path
```

Example:
```
package:migration se468 laravel-package-generators-extended LaravelPackageGeneratorsExtended TestMigration
```

**Model**
```
package:model {vendor} {package} {namespace} {name} --path
```

Example:
```
package:migration se468 laravel-package-generators-extended LaravelPackageGeneratorsExtended TestModel
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
