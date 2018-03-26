<?php

namespace se468\LaravelPackageGeneratorsExtended;

use Illuminate\Support\ServiceProvider;

class LaravelPackageGeneratorsExtendedServiceProvider extends ServiceProvider
{
    protected $commands = [
        'se468\LaravelPackageGeneratorsExtended\Commands\MakePackage',
        'se468\LaravelPackageGeneratorsExtended\Commands\MakeCommand',
        'se468\LaravelPackageGeneratorsExtended\Commands\MakeController',
        'se468\LaravelPackageGeneratorsExtended\Commands\MakeModel',
        'se468\LaravelPackageGeneratorsExtended\Commands\MakeMigration',
    ];
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $this->publishes([
            __DIR__.'/config/package-generators.php' => config_path('package-generators.php'),
        ]);
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands($this->commands);
    }
}