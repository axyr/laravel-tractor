<?php

namespace Axyr\CrudGenerator\Generators;

use Illuminate\Support\Str;

class RoutesGenerator extends AbstractGenerator
{
    public function path(): string
    {
        $parts = array_filter([$this->basePath(), $this->module(), 'routes.php']);

        return sprintf('%s', implode('/', $parts));
    }

    public function controllerGenerator(): ControllerGenerator
    {
        return ControllerGenerator::new($this->name, $this->module);
    }

    public function replacements(): array
    {
        return array_merge(parent::replacements(), [
            '{{routeName}}' => $this->variableNamePlural(),
            '{{controllerFullyQyalifiedClassName}}' => $this->controllerGenerator()->fullyQyalifiedClassName(),
            '{{controllerClassName}}' => $this->controllerGenerator()->className(),
        ]);
    }

    public function getStubContent(): string
    {
        if (file_exists($this->fullPath())) {
            return file_get_contents($this->fullPath());
        }

        return parent::getStubContent();
    }

    public function content(): string
    {
        $content = $this->getStubContent();
        $route = $this->applyReplacements($this->route());

        return Str::replaceLast(';', ";\n" . $route, $content);
    }

    public function route(): string
    {
        return "Route::apiResource('{{routeName}}', \{{controllerFullyQyalifiedClassName}}::class);";
    }
}
