<?php

declare(strict_types=1);

namespace Axyr\Tractor\Tests\Commands;

use Axyr\Tractor\Tests\TestCase;
use Illuminate\Support\Facades\File;

final class TractorGenerateTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->deleteGeneratedMigrations();
    }

    protected function tearDown(): void
    {
        $this->deleteGeneratedMigrations();

        parent::tearDown();
    }

    public function test_creates_the_migration_by_default(): void
    {
        $this->artisan('tractor:generate', ['name' => 'Post'])->assertSuccessful();

        $this->assertCount(1, $this->generatedMigrations());
    }

    public function test_skips_the_migration_with_the_no_migration_option(): void
    {
        $this->artisan('tractor:generate', ['name' => 'Post', '--no-migration' => true])->assertSuccessful();

        $this->assertCount(0, $this->generatedMigrations());
    }

    protected function generatedMigrations(): array
    {
        return File::glob(database_path('migrations/*_create_posts_table.php'));
    }

    protected function deleteGeneratedMigrations(): void
    {
        File::delete($this->generatedMigrations());
    }
}
