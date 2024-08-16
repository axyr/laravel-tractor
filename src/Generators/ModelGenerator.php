<?php

namespace Axyr\Tractor\Generators;

class ModelGenerator extends AbstractGenerator
{
    public function directory(): string
    {
        return 'Models';
    }

    public function replacements(): array
    {
        return array_merge(parent::replacements(), [
            '{{modelName}}' => $this->className(),
        ]);
    }
}
