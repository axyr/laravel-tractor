<?php

namespace Axyr\CrudGenerator;

use Axyr\CrudGenerator\Commands\GenerateCrud;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\PackageManifest as BasePackageManifest;
use Illuminate\Support\ServiceProvider;

class CrudGeneratorServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerConfig();
        $this->overridePackageManifest();
    }

    public function boot(): void
    {
        $this->bootCommands();
    }

    protected function registerConfig(): void
    {
        $file = __DIR__ . '/../config/crudgenerator.php';

        $this->mergeConfigFrom($file, 'crudgenerator');
        $this->publishes([$file => config_path('crudgenerator.php')]);
    }

    protected function bootCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                GenerateCrud::class,
            ]);
        }
    }

    public function overridePackageManifest(): void
    {
        $this->app->instance(
            BasePackageManifest::class,
            new PackageManifest(
                new Filesystem(),
                $this->app->basePath(),
                $this->app->getCachedPackagesPath()
            )
        );
    }
}
