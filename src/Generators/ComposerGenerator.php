<?php

namespace Axyr\Tractor\Generators;

class ComposerGenerator extends AbstractGenerator
{
    public function path(): string
    {
        $parts = array_filter([$this->basePath(), $this->module(), 'composer.json']);

        return sprintf('%s', implode('/', $parts));
    }

    public function composerName(): string
    {
        return config('tractor.composer.vendor_prefix') . '/' . strtolower($this->module());
    }

    public function autoloadPath(): string
    {
        return $this->escapeBackslashes($this->baseNamespace()) . '\\\\' . $this->module();
    }

    public function moduleServiceProviderGenerator(): ModuleServiceProviderGenerator
    {
        return ModuleServiceProviderGenerator::new($this->name, $this->module);
    }

    public function replacements(): array
    {
        return array_merge(parent::replacements(), [
            '{{composerName}}' => $this->composerName(),
            '{{autoloadPath}}' => $this->autoloadPath(),
            '{{serviceProviderFullyQyalifiedClassName}}' => $this->escapeBackslashes($this->moduleServiceProviderGenerator()->fullyQyalifiedClassName()),
        ]);
    }

    public function escapeBackslashes(string $string): string
    {
        return str_replace('\\', '\\\\', $string);
    }
}
