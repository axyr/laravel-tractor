# 📨  Another Laravel CRUD Generator

Another Laravel CRUD generator.

This generator only generates the PHP files for a route model based resource controllers.

Not frontend, no UI, just JSON based backend code.

## Repository and QueryFilter based controllers
This package is a bit different, as it will include Repository and QueryFilter classes for each CRUD.

The Repositories are very simple classes that wire up the QueryFilters with the Controllers.

The QueryFilters are based on the outstanding Laracasts tutorial:

https://laracasts.com/series/eloquent-techniques/episodes/4

THe biggest difference with this implementation of the Dedicated Query filters, is that we use a plain array instead of the Request object.
This makes it easier to reuse the Filters in Jobs, where you don't want to serialize the Request object.

https://github.com/axyr/laravel-query-filters

## Generated files

The generate command will generate the following files:

- Model
- Controller
- Resources
- Requests
- Policy
- Factory
- migration
- Repository
- Filter
- ControllerTest
- ControllerAuthorisationTest
- FilterTest

## Modules

By Default the files will be installed in a app/Modules/{Model} directory.

The philosophy here is that with Repositories, Filters and Policy classes, we are highly likely creating an above average complex application, 
where we want strict separation of concerns from the start and not only groupd files by type only.
