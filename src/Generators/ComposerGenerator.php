<?php

namespace Axyr\CrudGenerator\Generators;

class ComposerGenerator extends AbstractGenerator
{
    public function directory(): string
    {
        return '';
    }

    public function path(): string
    {
        $parts = array_filter([$this->basePath(), $this->module(), 'composer.json']);

        return sprintf('%s', implode('/', $parts));
    }

    public function composerName(): string
    {
        return config('crudgenerator.composer.vendor_prefix') . '/' . strtolower($this->module());
    }

    public function autoloadPath(): string
    {
        return str_replace('\\', '\\\\', $this->baseNamespace()) . '\\\\' . $this->module();
    }

    public function replacements(): array
    {
        return array_merge(parent::replacements(), [
            '{{composerName}}' => $this->composerName(),
            '{{autoloadPath}}' => $this->autoloadPath(),
        ]);
    }
}
