<?php

namespace se468\LaravelPackageGeneratorsExtended\Commands;

use se468\LaravelPackageGeneratorsExtended\Commands\PackageGeneratorCommand;
use Illuminate\Filesystem\Filesystem;


class MakeMigration extends PackageGeneratorCommand
{
    protected $signature = 'package:migration {name : The name of the migration} {vendor?} {package?} {namespace?} 
        {--path= : The location where the migration file should be created relative to package src folder.}';

    protected $description = 'Create a new migration file for your package. package:migration {name_of_file} {vendor?} {package?} {namespace?} --path';

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
            return $this->getPackagePath().'/database/migrations/'. $targetPath.'/' . $name . '.php';
        }

        return $this->getPackagePath() . '/database/migrations/' . date('Y_m_d_His') . '_' . $name . '.php';
    }

    protected function compileStub () {
        $stub = $this->files->get(__DIR__ . '/../stubs/Migration.stub');

        $this->replaceClassName($stub);

        return $stub;
    }

    protected function replaceClassName(&$stub) {

        $className = ucwords(str_singular(camel_case($this->argument('name'))));

        $stub = str_replace('{{class}}', $className, $stub);

        return $this;
    }
}
