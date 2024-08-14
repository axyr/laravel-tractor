<?php

namespace Axyr\CrudGenerator\Generators;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class CombinedGenerator
{
    private array $generatedFiles = [];

    public function __construct(protected string $name, protected ?string $module = null)
    {
    }

    public function generators(): array
    {
        return [
            ModelGenerator::class,
            ControllerGenerator::class,
            FactoryGenerator::class,
            FilterGenerator::class,
            PolicyGenerator::class,
            RepositoryGenerator::class,
            RequestGenerator::class,
            ResourceGenerator::class,
            PermissionSeederGenerator::class,
        ];
    }

    public function generate(): void
    {
        $this->generateClassFiles();
        $this->generateMigration();
    }

    private function generateClassFiles(): void
    {
        foreach ($this->generators() as $generatorClass) {
            /** @var \Axyr\CrudGenerator\Generators\AbstractGenerator $generator */
            $generator = new $generatorClass($this->name, $this->module);
            $generator->write();
            $this->generatedFiles[] = $generator->path();
        }
    }

    private function generateMigration(): void
    {
        $command = sprintf('make:migration create_%s_table', strtolower(Str::plural($this->name)));

        Artisan::call($command);
    }

    public function generatedFiles(): array
    {
        return $this->generatedFiles;
    }
}
