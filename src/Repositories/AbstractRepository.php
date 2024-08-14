<?php

namespace Axyr\CrudGenerator\Repositories;

use Axyr\CrudGenerator\Filters\Contracts\Filters;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

abstract class AbstractRepository
{
    protected ?int $perPage = 10;

    protected ?Authenticatable $user = null;

    protected Filters $filters;

    public function __construct(Filters $filters)
    {
        $this->filters = $filters;
    }

    abstract public function query(): Builder;

    public static function make(): static
    {
        return app(static::class);
    }

    public function setRequest(Request $request): static
    {
        return $this
            ->setFilters($request->all())
            ->setUser($request->user())
            ->setPerPage($request->get('per_page'));
    }

    public function setFilters(array $filters): static
    {
        $this->filters->setFilters($filters);

        return $this;
    }

    public function setUser(Authenticatable $user): static
    {
        $this->user = $user;
        $this->filters->setUser($user);

        return $this;
    }

    public function setPerPage(int|null $perPage = 10): static
    {
        $this->perPage = $perPage;

        return $this;
    }

    public function filters(): Filters
    {
        return $this->filters;
    }

    public function get(): Collection
    {
        return $this->query()->get();
    }

    public function paginate(int|null $perPage = null): Collection|LengthAwarePaginator
    {
        return $this->query()->paginate($perPage ?: $this->perPage);
    }

    public function user(): ?Authenticatable
    {
        return $this->user;
    }
}
