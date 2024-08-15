<?php

namespace Axyr\CrudGenerator\Generators;

use Illuminate\Support\Str;

class ModuleServiceProviderGenerator extends AbstractGenerator
{
    public function directory(): string
    {
        return '';
    }

    public function className(): string
    {
        return sprintf('%sServiceProvider', Str::singular($this->module()));
    }

    public function replacements(): array
    {
        return array_merge(parent::replacements(), [
            '{{serviceProviderName}}' => $this->className(),
        ]);
    }
}
