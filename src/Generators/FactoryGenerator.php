<?php

namespace Axyr\Tractor\Generators;

class FactoryGenerator extends AbstractGenerator
{
    public function directory(): string
    {
        return 'Factories';
    }

    public function className(): string
    {
        return sprintf('%sFactory', $this->name());
    }

    public function replacements(): array
    {
        return array_merge(parent::replacements(), [
            '{{factoryName}}' => $this->className(),
        ]);
    }
}
