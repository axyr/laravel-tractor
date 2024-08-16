<?php

namespace Axyr\CrudGenerator\Generators;

use Illuminate\Support\Str;
use ReflectionClass;

abstract class AbstractGenerator
{
    public bool $overwriteExistingFile = true;

    public function __construct(protected string $name, protected ?string $module = null)
    {
        $this->name = Str::singular($this->name);

        if ( ! $this->module) {
            $this->module = Str::plural($this->name);
        }
    }

    public static function new(string $name, ?string $module = null): static
    {
        return new static($name, $module);
    }

    public function directory(): string
    {
        return '';
    }

    public function stubName(): string
    {
        $reflect = new ReflectionClass($this);

        return str_replace('Generator', '', $reflect->getShortName());
    }

    public function className(): string
    {
        return $this->name;
    }

    public function variableName(): string
    {
        return strtolower($this->name);
    }

    public function variableNamePlural(): string
    {
        return Str::plural($this->variableName());
    }

    public function module(): string
    {
        return $this->module;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function namePlural(): string
    {
        return Str::plural($this->name());
    }

    public function basePath(): string
    {
        return config('crudgenerator.base_path');
    }

    public function baseNamespace(): string
    {
        return config('crudgenerator.base_namespace');
    }

    public function srcDirectory(): ?string
    {
        return config('crudgenerator.src_directory');
    }

    public function testDirectory(): ?string
    {
        return config('crudgenerator.test_directory');
    }

    public function fileSuffix(): string
    {
        return '.php';
    }

    public function path(): string
    {
        $parts = array_filter([$this->basePath(), $this->module(), $this->srcDirectory(), $this->directory(), $this->className()]);

        return sprintf('%s%s', implode('/', $parts), $this->fileSuffix());
    }

    public function fullPath(): string
    {
        return base_path($this->path());
    }

    public function namespace(): string
    {
        $directory = str_replace('/', '\\', $this->directory());
        $parts = array_filter([$this->baseNamespace(), $this->module(), $directory]);

        return implode('\\', $parts);
    }

    public function fullyQyalifiedClassName(): string
    {
        return $this->namespace() . '\\' . $this->className();
    }

    public function write(): void
    {
        $file = $this->fullPath();

        if ( ! file_exists($dir = pathinfo($file, PATHINFO_DIRNAME))) {
            mkdir($dir, 0777, true);
        }

        if ($this->shouldWriteFile($file)) {
            file_put_contents($file, $this->content());
        }
    }

    public function shouldWriteFile(string $file): bool
    {
        return $this->overwriteExistingFile || ! file_exists($file);
    }

    public function content(): string
    {
        return $this->applyReplacements($this->getStubContent());
    }

    public function applyReplacements(string $content): string
    {
        return str_replace(
            array_keys($this->replacements()),
            array_values($this->replacements()),
            $content
        );
    }

    public function getStubContent(): string
    {
        return $this->getStub($this->stubName());
    }

    public function getStub(string $name): string
    {
        return file_get_contents(__DIR__ . "/../../resources/stubs/$name.stub");
    }

    public function userModelClassName(): string
    {
        return config('auth.providers.users.model');
    }

    public function roleModelClassName(): string
    {
        return config('permission.models.role');
    }

    public function userModelShortName(): string
    {
        $reflect = new ReflectionClass($this->userModelClassName());

        return $reflect->getShortName();
    }

    public function replacements(): array
    {
        return [
            '{{baseNamespace}}' => $this->baseNamespace(),
            '{{namespace}}' => $this->namespace(),
            '{{srcDirectory}}' => $this->srcDirectory(),
            '{{testDirectory}}' => $this->testDirectory(),
            '{{moduleName}}' => $this->module(),
            '{{modelName}}' => $this->name(),
            '{{modelNamePlural}}' => $this->namePlural(),
            '{{variableName}}' => $this->variableName(),
            '{{variableNamePlural}}' => $this->variableNamePlural(),
            '{{userModelClassName}}' => $this->userModelClassName(),
            '{{userModelShortName}}' => $this->userModelShortName(),
            '{{roleModelClassName}}' => $this->roleModelClassName(),
        ];
    }
}
