<?php


use Axyr\CrudGenerator\CrudGeneratorServiceProvider;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Orchestra\Testbench\Concerns\WithWorkbench;

class TestCase extends \Orchestra\Testbench\TestCase
{
    use WithWorkbench;

    protected $enablesPackageDiscoveries = true;

    protected ?Carbon $now = null;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::deleteDirectory('');

        Carbon::setTestNow($this->now = now());
    }

    protected function getPackageProviders($app)
    {
        return [
            CrudGeneratorServiceProvider::class,
        ];
    }
}
