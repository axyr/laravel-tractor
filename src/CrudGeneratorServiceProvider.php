<?php

namespace Axyr\CrudGenerator;

use Illuminate\Support\ServiceProvider;

class CrudGeneratorServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerConfig();
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

            ]);
        }
    }
}
