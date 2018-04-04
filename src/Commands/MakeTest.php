<?php

namespace se468\LaravelPackageGeneratorsExtended\Commands;

use se468\LaravelPackageGeneratorsExtended\Commands\PackageGeneratorCommand;
use Illuminate\Filesystem\Filesystem;

class MakeTest extends PackageGeneratorCommand
{
    protected $signature = 'package:test {name : The name of the test} {vendor?} {package?} {namespace?}
        {--path= : The location where the test file should be created relative to package src/tests folder.}';

    protected $description = 'Create a new test file for your package. package:test {name_of_file} {vendor?} {package?} {namespace?}  --path';

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
        $path = $this->getPath($this->argument('name'));

        $this->beforeGeneration($path);

        $this->makeDirectory($path);

        $this->files->put($path, $this->compileStub());

        $this->afterGeneration($path);
    }

    protected function getPath($name)
    {
        $vendor = $this->argument('vendor') ? $this->argument('vendor') : config('package-generators.vendor');

        $package = $this->argument('package') ? $this->argument('package') : config('package-generators.package');


        $testDir = base_path() . '/packages/'. $vendor .'/'. $package .'/tests';
        if (! is_null($targetPath = $this->input->getOption('path'))) {
            return $testDir. '/'. $targetPath.'/' . $name . '.php';
        }

        return $testDir. '/' . $name . '.php';
    }

    protected function compileStub()
    {
        $stub = $this->files->get(__DIR__ . '/../stubs/Test.stub');

        $this->replaceNamespace($stub)
            ->replaceClassName($stub);

        return $stub;
    }

    protected function replaceClassName(&$stub)
    {
        $stub = str_replace('{{class}}', $this->argument('name'), $stub);

        return $this;
    }
}
