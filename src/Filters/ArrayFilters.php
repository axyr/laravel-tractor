<?php

namespace Axyr\Tractor\Filters;

use Axyr\Tractor\Filters\Contracts\Filters;
use Axyr\Tractor\Filters\Traits\ExtendsFilters;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use ReflectionMethod;

abstract class ArrayFilters implements Filters
{
    use ExtendsFilters;

    protected ?Authenticatable $user = null;

    protected ?Builder $query = null;

    public function __construct(protected array $filters = [])
    {
    }

    public function setUser(Authenticatable $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function setFilters(array $filters): static
    {
        $this->filters = $filters;

        return $this;
    }

    public function addFilters(array $filters): static
    {
        foreach ($filters as $name => $value) {
            $this->setFilter($name, $value);
        }

        return $this;
    }

    public function setFilter(string $name, mixed $value): static
    {
        $this->filters[$name] = $value;

        return $this;
    }

    public function getFilters(): array
    {
        return $this->filters;
    }

    public function getFilterValue(string $filterName): mixed
    {
        return $this->filters[$filterName] ?? null;
    }

    public function applyToQuery(Builder $query): Builder
    {
        $this->query = $query;

        $this->ensureNumericParameters();

        foreach ($this->getFilters() as $filter => $value) {
            if ($this->filterCanBeApplied($filter, $value)) {
                $this->{Str::camel($filter)}($value);
            }
        }

        return $query;
    }

    protected function ensureNumericParameters(): void
    {
        foreach ($this->numericParameters as $parameter) {
            if (isset($this->filters[$parameter])) {
                $this->filters[$parameter] = (int)$this->filters[$parameter];
            }
        }
    }

    protected function filterCanBeApplied(string $filter, mixed $value): bool
    {
        $method = Str::camel($filter);

        if ( ! method_exists($this, $method)) {
            return false;
        }

        if ($value !== '' && $value !== null) {
            $data = Arr::only($this->getFilters(), $filter);
            $rules = Arr::only($this->getRules(), $filter);

            return ! Validator::make($data, $rules)->fails();
        }

        return (new ReflectionMethod($this, $method))->getNumberOfParameters() === 0;
    }

    protected function getRules(): array
    {
        return [];
    }
}
