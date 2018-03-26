<?php

namespace se468\LaravelPackageGeneratorsExtended\Commands;

use se468\LaravelPackageGeneratorsExtended\Commands\PackageGeneratorCommand;
use Illuminate\Filesystem\Filesystem;


class MakePackage extends PackageGeneratorCommand
{
    protected $signature = 'package:create {vendor} {package} {namespace}';

    protected $description = 'Create a new package service provider. package:command {vendor} {package} {namespace}';

    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    public function handle()
    {
        $this->makeCommand();
    }

    protected function makeCommand()
    {
        $path = $this->getPath($this->argument('namespace'));
        
        $this->beforeGeneration($path);

        $this->makeDirectory($path);

        $this->files->put($path, $this->compileStub());

        $this->afterGeneration($path);
    }

    protected function getPath($name)
    {
        return $this->getPackagePath().'/' . $name . 'ServiceProvider.php';
    }

    protected function compileStub () {
        $stub = $this->files->get(__DIR__ . '/../stubs/ServiceProvider.stub');

        $this->replaceNamespace($stub);

        return $stub;
    }

    protected function replaceClassName(&$stub) {
        $stub = str_replace('{{class}}', $this->argument('name'), $stub);

        return $this;
    }
}
