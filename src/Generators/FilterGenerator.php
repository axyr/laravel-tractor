<?php

namespace Axyr\Tractor\Generators;

class FilterGenerator extends AbstractGenerator
{
    public function directory(): string
    {
        return 'Filters';
    }

    public function className(): string
    {
        return sprintf('%sFilter', $this->name());
    }

    public function replacements(): array
    {
        return array_merge(parent::replacements(), [
            '{{filterName}}' => $this->className(),
        ]);
    }
}
