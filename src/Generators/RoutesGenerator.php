<?php

namespace Axyr\CrudGenerator\Generators;

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
            '{{controllerName}}' => $this->controllerGenerator()->className(),
            '{{controllerNamespace}}' => $this->controllerGenerator()->namespace(),
        ]);
    }
}
