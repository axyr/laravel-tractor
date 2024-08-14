<?php

namespace Axyr\CrudGenerator\Filters;

class SearchValueSplitter
{
    public static function split(array|string $ids): array
    {
        $values = is_string($ids) ? preg_split("/[\s,]+/", $ids) : $ids;

        return array_values(array_filter($values));
    }
}
