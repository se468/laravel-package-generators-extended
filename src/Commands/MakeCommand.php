<?php

namespace se468\LaravelPackageGeneratorsExtended\Commands;

use se468\LaravelPackageGeneratorsExtended\Commands\PackageGeneratorCommand;
use Illuminate\Filesystem\Filesystem;

class MakeCommand extends PackageGeneratorCommand
{
    protected $signature = 'package:command {name : The name of the command} {vendor?} {package?} {namespace?}
        {--path= : The location where the command file should be created relative to package src folder.}';

    protected $description = 'Create a new command file for your package. package:command {name_of_file} {vendor?} {package?} {namespace?} --path';

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
        if (! is_null($targetPath = $this->input->getOption('path'))) {
            return $this->getPackagePath().'/src/Commands/'. $targetPath.'/' . $name . '.php';
        }

        return $this->getPackagePath().'/src/Commands/' . $name . '.php';
    }

    protected function compileStub()
    {
        $stub = $this->files->get(__DIR__ . '/../stubs/Command.stub');

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
