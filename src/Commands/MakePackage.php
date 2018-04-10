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
        $this->addToLaravelConfig();
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
        return $this->getPackagePath() . '/src/' . $name . 'ServiceProvider.php';
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

    protected function addToLaravelComposer()
    {
        $composerJSON = json_decode($this->files->get(getcwd() . '/composer.json'), true);

        if (!isset($composerJSON["autoload-dev"])) {
            $composerJSON["autoload-dev"] = [];
        }
        
        if (!isset($composerJSON["autoload-dev"]["psr-4"])) {
            $composerJSON["autoload-dev"]["psr-4"] = [];
        }

        $key = sprintf("%s\\%s\\", $this->argument('vendor'), $this->argument('namespace'));
        $value = sprintf("packages/%s/%s/src", $this->argument('vendor'), $this->argument('package'));

        $composerJSON["autoload-dev"]["psr-4"][$key] = $value;

        $this->files->put(getcwd() . '/composer.json', json_encode($composerJSON, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    protected function addToLaravelConfig()
    {
        // Add path to config/app.php.

        // {vendor}\{namespace}\{namespace}ServiceProvider::class

        $newLine = sprintf(
            "\n\n        %s\%s\%sServiceProvider::class,",
            $this->argument('vendor'),
            $this->argument('namespace'),
            $this->argument('namespace')
        );
        $configFile = $this->files->get(getcwd() . '/config/app.php');

        $needle = "App\Providers\RouteServiceProvider::class,";
        $positionToInsert = strpos($configFile, $needle) + strlen($needle);

        $newConfigFile = substr_replace($configFile, $newLine, $positionToInsert, 0);

        $this->files->put(getcwd() . '/config/app.php', $newConfigFile);
    }

    protected function afterGeneration($path)
    {
        $this->addToLaravelComposer();

        

        parent::afterGeneration($path);
    }
}
