<?php

namespace Axyr\Tractor\Generators;

class ResourceGenerator extends AbstractGenerator
{
    public function directory(): string
    {
        return 'Http/Resources';
    }

    public function className(): string
    {
        return sprintf('%sResource', $this->name());
    }

    public function mixin(): string
    {
        return sprintf('\%s\%s\Models\%s', $this->baseNamespace(), $this->module(), $this->name());
    }

    public function replacements(): array
    {
        return array_merge(parent::replacements(), [
            '{{resourceName}}' => $this->className(),
            '{{mixin}}' => $this->mixin(),
        ]);
    }
}
