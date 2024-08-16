<?php

namespace Axyr\Tractor\Tests;

use Axyr\Tractor\TractorServiceProvider;
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

        File::deleteDirectory(base_path(config('tractor.base_path')));

        Carbon::setTestNow($this->now = now());
    }

    protected function getPackageProviders($app)
    {
        return [
            PermissionServiceProvider::class,
            TractorServiceProvider::class,
        ];
    }
}
