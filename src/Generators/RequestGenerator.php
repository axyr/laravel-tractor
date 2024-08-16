<?php

namespace Axyr\Tractor\Generators;

class RequestGenerator extends AbstractGenerator
{
    public function directory(): string
    {
        return 'Http/Requests';
    }

    public function className(): string
    {
        return sprintf('%sRequest', $this->name());
    }

    public function replacements(): array
    {
        return array_merge(parent::replacements(), [
            '{{requestName}}' => $this->className(),
        ]);
    }
}
