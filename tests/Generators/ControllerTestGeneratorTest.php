<?php

namespace Axyr\Tractor\Tests\Generators;

use Axyr\Tractor\Generators\ControllerTestGenerator;

class ControllerTestGeneratorTest extends GeneratorTestAbstract
{
    public function generatorClassName(): string
    {
        return ControllerTestGenerator::class;
    }

    public static function dataGenerator(): array
    {
        return [
            [
                'name' => 'Post',
                'module' => 'Posts',
                'expectedPath' => 'app-modules/Posts/tests/Http/Controllers/PostControllerTest.php',
                'expectedStrings' => [
                    'namespace App\Modules\Posts\Tests\Http\Controllers;',
                    'class PostControllerTest extends TestCase',
                    'use App\Modules\Posts\Factories\PostFactory;',
                    'use App\Modules\Posts\Models\Post;',
                    'use App\Modules\Posts\Seeders\PostPermissionSeeder;',
                    'use Spatie\Permission\Models\Role;',
                    '(new PostPermissionSeeder)->run();',
                    'function testItListsPosts',
                    'function testItCreatesAPost',
                    'function testItShowsAPost',
                    'function testItUpdatesAPost',
                    'function testItDeletesAPost',
                    '$post = PostFactory::new()->create();',
                    '->getJson(\'posts?per_page=10\')',
                    '"posts/{$post->id}"',
                ],
            ],
        ];
    }
}
