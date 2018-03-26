<?php

namespace se468\LaravelPackageGeneratorsExtended\Commands;

use Illuminate\Filesystem\Filesystem;
use se468\LaravelPackageGeneratorsExtended\Commands\PackageGeneratorCommand;

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
        $this->files->put($this->getPackagePath().'/composer.json', $this->compileComposerStub());
        $this->afterGeneration($path);
    }

    protected function getPath($name)
    {
        return $this->getPackagePath() . '/' . $name . 'ServiceProvider.php';
    }

    

    protected function compileStub()
    {
        $stub = $this->files->get(__DIR__ . '/../stubs/ServiceProvider.stub');

        $this->replaceNamespace($stub);

        return $stub;
    }

    protected function compileComposerStub()
    {
        $stub = $this->files->get(__DIR__ . '/../stubs/composer.stub');
        $this->replaceNamespace($stub)
            ->replacePackageName($stub);

        return $stub;
    }

    protected function replacePackageName(&$stub)
    {
        $stub = str_replace('{{package}}', $this->argument('package'), $stub);

        return $this;
    }
}
