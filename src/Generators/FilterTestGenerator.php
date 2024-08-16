<?php

namespace Axyr\CrudGenerator\Generators;

class FilterTestGenerator extends AbstractGenerator
{
    public function path(): string
    {
        $parts = array_filter([$this->basePath(), $this->module(), $this->testDirectory(), $this->directory(), $this->className()]);

        return sprintf('%s%s', implode('/', $parts), $this->fileSuffix());
    }

    public function directory(): string
    {
        return 'Filters';
    }

    public function className(): string
    {
        return sprintf('%sFilterTest', $this->name());
    }

    public function replacements(): array
    {
        return array_merge(parent::replacements(), [
            '{{testClassName}}' => $this->className(),
        ]);
    }
}
