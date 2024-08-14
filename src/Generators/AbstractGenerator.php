<?php

namespace Axyr\CrudGenerator\Generators;

use Illuminate\Support\Str;
use ReflectionClass;

abstract class AbstractGenerator
{
    public function __construct(protected string $name, protected ?string $module = null)
    {
        $this->name = Str::singular($this->name);

        if ( ! $this->module) {
            $this->module = Str::plural($this->name);
        }
    }

    abstract public function directory(): string;

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

    public function basePath(): string
    {
        return config('crudgenerator.base_path');
    }

    public function baseNamespace(): string
    {
        return config('crudgenerator.base_namespace');
    }

    public function path(): string
    {
        return sprintf('%s/%s/%s/%s.php', $this->basePath(), $this->module(), $this->directory(), $this->className());
    }

    public function namespace(): string
    {
        $directory = str_replace('/', '\\', $this->directory());

        return sprintf('%s\\%s\\%s', $this->baseNamespace(), $this->module(), $directory);
    }

    public function write(): void
    {
        $file = base_path($this->path());

        if ( ! file_exists($dir = pathinfo($file, PATHINFO_DIRNAME))) {
            mkdir($dir, 0777, true);
        }

        file_put_contents($file, $this->content());
    }

    public function content(): string
    {
        return str_replace(
            array_keys($this->replacements()),
            array_values($this->replacements()),
            $this->getStub($this->stubName())
        );
    }

    public function getStub(string $name): string
    {
        return file_get_contents(__DIR__ . "/../../resources/stubs/$name.stub");
    }

    public function userModelClassName(): string
    {
        return config('auth.providers.users.model');
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
            '{{moduleName}}' => $this->module(),
            '{{modelName}}' => $this->name(),
            '{{variableName}}' => $this->variableName(),
            '{{variableNamePlural}}' => $this->variableNamePlural(),
            '{{userModelClassName}}' => $this->userModelClassName(),
            '{{userModelShortName}}' => $this->userModelShortName(),
        ];
    }
}