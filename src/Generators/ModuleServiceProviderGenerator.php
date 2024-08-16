<?php

namespace Axyr\Tractor\Generators;

use Illuminate\Support\Str;

class ModuleServiceProviderGenerator extends AbstractGenerator
{
    public bool $overwriteExistingFile = false;

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
