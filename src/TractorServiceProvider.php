<?php

namespace Axyr\Tractor;

use Axyr\Tractor\Commands\TractorGenerate;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\PackageManifest as BasePackageManifest;
use Illuminate\Support\ServiceProvider;

class TractorServiceProvider extends ServiceProvider
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
        $file = __DIR__ . '/../config/tractor.php';

        $this->mergeConfigFrom($file, 'tractor');
        $this->publishes([$file => config_path('tractor.php')]);
    }

    protected function bootCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                TractorGenerate::class,
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
