<?php

namespace Axyr\CrudGenerator\Filters\Contracts;

use Illuminate\Database\Eloquent\Builder;

interface Filters
{
    public function setFilters(array $filters): static;

    public function getFilterValue(string $filterName): mixed;

    public function applyToQuery(Builder $query): Builder;
}
