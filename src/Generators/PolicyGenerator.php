<?php

namespace Axyr\Tractor\Generators;

class PolicyGenerator extends AbstractGenerator
{
    public function directory(): string
    {
        return 'Policies';
    }

    public function className(): string
    {
        return sprintf('%sPolicy', $this->name());
    }

    public function replacements(): array
    {
        return array_merge(parent::replacements(), [
            '{{policyName}}' => $this->className(),
        ]);
    }
}
