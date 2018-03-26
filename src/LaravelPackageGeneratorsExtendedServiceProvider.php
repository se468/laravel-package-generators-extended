<?php

namespace se468\LaravelPackageGeneratorsExtended;

use Illuminate\Support\ServiceProvider;

class LaravelPackageGeneratorsExtendedServiceProvider extends ServiceProvider
{
    protected $commands = [
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