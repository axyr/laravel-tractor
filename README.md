# 🚜 Laravel Tractor - Another Laravel API Module Generator

Scaffold a Laravel module structure for JSON API's.

![](docs/img/tractor.jpg)

## Introduction

Laravel Tractor is another module scaffolder for generating the basic PHP classes commonly used for JSON API's.
The scaffolder is mainly targetted on stand alone API's without any Blade, Livewire or any other frontend library.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/axyr/tractor.svg?style=flat-square)](https://packagist.org/packages/axyr/tractor) [![Tests](https://github.com/axyr/laravel-tractor/actions/workflows/run-tests.yml/badge.svg)](https://github.com/axyr/laravel-tractor/actions/workflows/run-tests.yml)

After installing, you can generate all required files for a working CRUD based module:

```shell 
php artisan tractor:generate Post
```

Above command will generate a basic module structure with all the files needed for a model based JSON API.

The module will have boilerplate tests that tests all the permission authorization, database operations and filters.

```
📂 app
📂 app-modules
 ┗ 📂 Posts
   ┗ 📂 src
     ┗ 📂 Factories
       ┗ 📄 PostFactory.php
     ┗ 📂 Filters
       ┗ 📄 PostFilter.php
     ┗ 📂 Http
       ┗ 📂 Controllers
         ┗ 📄 PostController.php
       ┗ 📂 Requests
         ┗ 📄 PostRequest.php
       ┗ 📂 Resources
         ┗ 📄 PostResource.php
     ┗ 📂 Models
       ┗ 📄 Post.php
     ┗ 📂 Policies
       ┗ 📄 PostPolicy.php
     ┗ 📂 Repositories
       ┗ 📄 PostRepository.php
     ┗ 📂 Seeders
       ┗ 📄 PostSeeder.php
   ┗ 📂 tests
     ┗ 📂 Filters
       ┗ 📄 PostFilterTest.php
     ┗ 📂 Http
       ┗ 📂 Controllers
         ┗ 📄 PostControllerAuthorizationTest.php
         ┗ 📄 PostControllerTest.php
   ┗ 📄 composer.json
   ┗ 📄 routes.php
📂 database
┗ 📂 migrations   
  ┗ 📄 2024_08_16_135340_create_posts_table.php
```

## Examples

A full example of a generater module can be found here:

TODO

We generate the bare minimum, but workable and testable code, some examples:

### Model

```php
<?php

namespace App\Modules\Posts\Models;

use Axyr\CrudGenerator\Filters\Traits\FiltersRecords;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Post extends Model
{
    use FiltersRecords;

    protected $guarded = ['id'];
}
```

### Controller

```php
<?php

namespace Modules\Posts\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Posts\Models\Post;
use Modules\Posts\Repositories\PostRepository;
use Modules\Posts\Http\Requests\PostRequest;
use Modules\Posts\Http\Resources\PostResource;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

class PostController extends Controller
{
    use AuthorizesRequests;

    public function __construct(protected PostRepository $repository)
    {
        $this->authorizeResource(Post::class);
    }

    public function index(Request $request): ResourceCollection
    {
        $posts = $this->repository->setRequest($request)->paginate();

        return PostResource::collection($posts)->preserveQuery();
    }

    public function store(PostRequest $request): PostResource
    {
        $post = Post::query()->create($request->validated());

        return new PostResource($post);
    }

    public function show(Post $post): PostResource
    {
        return new PostResource($post);
    }

    public function update(PostRequest $request, Post $post): PostResource
    {
        $post->update($request->validated());

        return new PostResource($post);
    }

    public function destroy(Post $post): Response
    {
        $post->delete();

        return response()->noContent();
    }
}

```

### PermissionSeeder
For every resource we create a seeder that stores a permission for each Controller action:


```php
<?php

namespace App\Modules\Posts\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PostPermissionSeeder extends Seeder
{
    private null|Model|Role $defaultRole;

    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $this->createDefaultRole();
        $this->createPermissions();
    }

    private function createDefaultRole(): void
    {
        $defaultRoleName = config('crudgenerator.default_role_name');
        $defaultGuardName = config('crudgenerator.default_guard_name');

        $this->defaultRole = Role::query()->firstOrCreate(['name' => $defaultRoleName], ['guard_name' => $defaultGuardName]);

        $permission = Permission::query()->firstOrCreate(['name' => $defaultRoleName]);

        $this->defaultRole->givePermissionTo($permission);
    }

    private function createPermissions(): void
    {
        $viewAny = Permission::query()->firstOrCreate(['name' => 'post.viewAny']);
        $view = Permission::query()->firstOrCreate(['name' => 'post.view']);
        $create = Permission::query()->firstOrCreate(['name' => 'post.create']);
        $update = Permission::query()->firstOrCreate(['name' => 'post.update']);
        $delete = Permission::query()->firstOrCreate(['name' => 'post.delete']);

        $this->defaultRole->givePermissionTo($viewAny, $view, $create, $update, $delete);
    }
}

```

### ControllerAuthorizationTest

The ControllerAuthorizationTest test every permission for an allowed user and a restricted user.
In this way we are sure every Controller actions can be finegrained assigned to any future role.

```php
<?php

namespace App\Modules\Posts\Tests\Http\Controllers;

use App\Models\User;
use App\Modules\Posts\Factories\PostFactory;
use App\Modules\Posts\Models\Post;
use App\Modules\Posts\Seeders\PostPermissionSeeder;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class PostControllerAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function userWithRole(string $roleName, array $attributes = []): User
    {
        (new PostPermissionSeeder)->run();

        $defaultGuardName = config('crudgenerator.default_guard_name');
        $role = Role::query()->firstOrCreate(['name' => $roleName], ['guard_name' => $defaultGuardName]);

        return UserFactory::new()->create($attributes)->assignRole($role);
    }

    #[DataProvider('roleDataProvider')]
    public function testListPostAuthorization(string $role, bool $allow): void
    {
        $user = $this->userWithRole($role);

        $response = $this->actingAs($user)->get('posts');

        $this->assertEquals($allow, $user->can('viewAny', Post::class));
        $this->assertEquals($allow, $response->getStatusCode() !== Response::HTTP_FORBIDDEN, $response->getStatusCode());
    }

    #[DataProvider('roleDataProvider')]
    public function testCreatePostAuthorization(string $role, bool $allow): void
    {
        $user = $this->userWithRole($role);

        $response = $this->actingAs($user)->post('posts');

        $this->assertEquals($allow, $user->can('create', Post::class));
        $this->assertEquals($allow, $response->getStatusCode() !== Response::HTTP_FORBIDDEN, $response->getStatusCode());
    }

    #[DataProvider('roleDataProvider')]
    public function testUpdatePostAuthorization(string $role, bool $allow): void
    {
        $user = $this->userWithRole($role);
        $post = PostFactory::new()->create();

        $response = $this->actingAs($user)->patch("posts/{$post->id}");

        $this->assertEquals($allow, $user->can('update', $post));
        $this->assertEquals($allow, $response->getStatusCode() !== Response::HTTP_FORBIDDEN, $response->getStatusCode());
    }

    #[DataProvider('roleDataProvider')]
    public function testShowPostAuthorization(string $role, bool $allow): void
    {
        $user = $this->userWithRole($role);
        $post = PostFactory::new()->create();

        $response = $this->actingAs($user)->get("posts/{$post->id}");

        $this->assertEquals($allow, $user->can('view', $post));
        $this->assertEquals($allow, $response->getStatusCode() !== Response::HTTP_FORBIDDEN, $response->getStatusCode());
    }

    #[DataProvider('roleDataProvider')]
    public function testDeletePostAuthorization(string $role, bool $allow): void
    {
        $user = $this->userWithRole($role);
        $post = PostFactory::new()->create();

        $response = $this->actingAs($user)->delete("posts/{$post->id}");

        $this->assertEquals($allow, $user->can('delete', $post));
        $this->assertEquals($allow, $response->getStatusCode() !== Response::HTTP_FORBIDDEN, $response->getStatusCode());
    }

    public static function roleDataProvider(): array
    {
        return [
            'default role with permissions is allowed' => [
                'role' => 'admin',
                'allow' => true,
            ],
            'custom role without permissions is not allowed' => [
                'role' => 'not-allowed',
                'allow' => false,
            ],
        ];
    }
}

```

## Documentation

[https://axyr.gitbook.io/laravel-tractor](https://axyr.gitbook.io/laravel-tractor)

## Quick start


Run the composer install command from the terminal:

```shell
composer require axyr/laravel-tractor
```

Then you can generate a Module for a Model resource:

```shell
php artisan crud:generate Post -m
```

After that you can run the tests:

```shell
php artisan test
```

From here, you can start extending the module with your specific business cases.

For further information and customisation, visit our documentation page:

[https://axyr.gitbook.io/laravel-tractor](https://axyr.gitbook.io/laravel-tractor)
