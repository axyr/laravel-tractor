<?php

namespace Axyr\CrudGenerator\Generators;

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

            ModuleServiceProviderGenerator::class,
            ComposerGenerator::class,
            RoutesGenerator::class,

            ControllerAuthorizationTestGenerator::class,
            ControllerTestGenerator::class,
            FilterTestGenerator::class,
        ];
    }

    public function generate(): void
    {
        foreach ($this->generators() as $generatorClass) {
            /** @var \Axyr\CrudGenerator\Generators\AbstractGenerator $generator */
            $generator = new $generatorClass($this->name, $this->module);
            $generator->write();
            $this->generatedFiles[] = $generator->path();
        }
    }

    public function generatedFiles(): array
    {
        return $this->generatedFiles;
    }
}
