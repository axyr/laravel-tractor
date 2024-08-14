<?php

namespace Axyr\CrudGenerator\Generators;

class PermissionSeederGenerator extends AbstractGenerator
{
    public function directory(): string
    {
        return 'Seeders';
    }

    public function className(): string
    {
        return sprintf('%sPermissionSeeder', $this->name());
    }

    public function replacements(): array
    {
        return array_merge(parent::replacements(), [
            '{{seederName}}' => $this->className(),
        ]);
    }
}
