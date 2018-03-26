<?php

namespace se468\LaravelPackageGeneratorsExtended\Commands;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Console\Command;

abstract class PackageGeneratorCommand extends Command
{
    protected $signature;
    protected $description;
    protected $composer;

    public function __construct()
    {
        parent::__construct();
        $this->composer = app()['composer'];
    }

    public function handle()
    {
        //
    }


    protected function getPackagePath()
    {
        $vendor = $this->argument('vendor') ? $this->argument('vendor') : config('package-generators.vendor');

        $package = $this->argument('package') ? $this->argument('package') : config('package-generators.package');

        return base_path() . '/packages/'. $vendor .'/'. $package .'/src';
    }

    protected function makeDirectory ($path) {
        if (!$this->files->isDirectory(dirname($path))) {
            $this->files->makeDirectory(dirname($path), 0777, true, true);
        }
    }
    
    protected function beforeGeneration ($path) {
        

        if ($this->files->exists($path)) {
            return $this->error('The file already exists!');
        }
    }

    protected function afterGeneration ($path) {
        $this->info('Created successfully.'. $path);

        $this->composer->dumpAutoloads();
    }

    protected function replaceNamespace (&$stub) {
        $vendor = $this->argument('vendor') ? $this->argument('vendor') : config('package-generators.vendor');

        $namespace = $this->argument('namespace') ? $this->argument('namespace') : config('package-generators.namespace');

        $stub = str_replace('{{vendor}}', $vendor, $stub);
        $stub = str_replace('{{namespace}}', $namespace, $stub);

        return $this;
    }
}
