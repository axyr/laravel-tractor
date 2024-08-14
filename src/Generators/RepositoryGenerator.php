<?php

namespace Axyr\CrudGenerator\Generators;

class RepositoryGenerator extends AbstractGenerator
{
    public function directory(): string
    {
        return 'Repositories';
    }

    public function className(): string
    {
        return sprintf('%sRepository', $this->name());
    }

    public function replacements(): array
    {
        return array_merge(parent::replacements(), [
            '{{repositoryName}}' => $this->className(),
        ]);
    }
}
