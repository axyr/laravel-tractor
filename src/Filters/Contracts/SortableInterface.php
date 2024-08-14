<?php

namespace Axyr\CrudGenerator\Filters\Contracts;

interface SortableInterface
{
    public function sortableColumns(): array;
}
