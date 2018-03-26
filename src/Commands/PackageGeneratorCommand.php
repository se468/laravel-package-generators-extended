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
        return base_path() . '/packages/'.$this->argument('vendor').'/'.$this->argument('package').'/src';
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
        $stub = str_replace('{{vendor}}', $this->argument('vendor'), $stub);
        $stub = str_replace('{{namespace}}', $this->argument('namespace'), $stub);

        return $this;
    }
}
