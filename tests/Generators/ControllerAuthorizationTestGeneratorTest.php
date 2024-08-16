<?php

namespace Axyr\Tractor\Tests\Generators;

use Axyr\Tractor\Generators\ControllerAuthorizationTestGenerator;

class ControllerAuthorizationTestGeneratorTest extends GeneratorTestAbstract
{
    public function generatorClassName(): string
    {
        return ControllerAuthorizationTestGenerator::class;
    }

    public static function dataGenerator(): array
    {
        return [
            [
                'name' => 'Post',
                'module' => 'Posts',
                'expectedPath' => 'app-modules/Posts/tests/Http/Controllers/PostControllerAuthorizationTest.php',
                'expectedStrings' => [
                    'namespace App\Modules\Posts\Tests\Http\Controllers;',
                    'class PostControllerAuthorizationTest extends TestCase',
                    'use App\Modules\Posts\Factories\PostFactory;',
                    'use App\Modules\Posts\Models\Post;',
                    'use App\Modules\Posts\Seeders\PostPermissionSeeder;',
                    'use Spatie\Permission\Models\Role;',
                    '(new PostPermissionSeeder)->run();',
                    'function testListPostAuthorization',
                    'function testCreatePostAuthorization',
                    'function testUpdatePostAuthorization',
                    'function testShowPostAuthorization',
                    'function testDeletePostAuthorization',
                    '$post = PostFactory::new()->create();',
                    '$response = $this->actingAs($user)->get(\'posts\');',
                    '$this->assertEquals($allow, $user->can(\'viewAny\', Post::class));',
                    '$this->assertEquals($allow, $user->can(\'create\', Post::class));',
                    '$this->assertEquals($allow, $user->can(\'update\', $post));',
                    '$this->assertEquals($allow, $user->can(\'view\', $post));',
                    '$this->assertEquals($allow, $user->can(\'delete\', $post));',
                    '"posts/{$post->id}"',
                ],
            ],
        ];
    }
}
