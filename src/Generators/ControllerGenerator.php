<?php

namespace Axyr\Tractor\Generators;

class ControllerGenerator extends AbstractGenerator
{
    public function directory(): string
    {
        return 'Http/Controllers';
    }

    public function className(): string
    {
        return sprintf('%sController', $this->name());
    }

    public function replacements(): array
    {
        return array_merge(parent::replacements(), [
            '{{controllerName}}' => $this->className(),
        ]);
    }
}
