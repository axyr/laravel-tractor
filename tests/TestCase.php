<?php

namespace Axyr\CrudGenerator\Tests;

use Axyr\CrudGenerator\CrudGeneratorServiceProvider;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Spatie\Permission\PermissionServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    use WithWorkbench;

    protected $enablesPackageDiscoveries = true;

    protected ?Carbon $now = null;

    protected function setUp(): void
    {
        parent::setUp();

        File::deleteDirectory(base_path(config('crudgenerator.base_path')));

        Carbon::setTestNow($this->now = now());
    }

    protected function getPackageProviders($app)
    {
        return [
            PermissionServiceProvider::class,
            CrudGeneratorServiceProvider::class,
        ];
    }
}
