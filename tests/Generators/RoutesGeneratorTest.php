<?php

namespace Axyr\CrudGenerator\Tests\Generators;

use Axyr\CrudGenerator\Generators\RoutesGenerator;

class RoutesGeneratorTest extends GeneratorTestAbstract
{
    public function generatorClassName(): string
    {
        return RoutesGenerator::class;
    }

    public static function dataGenerator(): array
    {
        return [
            [
                'name' => 'Comment',
                'module' => 'Posts',
                'expectedPath' => 'app-modules/Posts/routes.php',
                'expectedStrings' => [
                    'use Illuminate\Support\Facades\Route;',
                    "Route::apiResource('comments', \App\Modules\Posts\Http\Controllers\CommentController::class);",
                ],
            ],
        ];
    }

    public function testItAppendsANewRouteToAnExistingRoutesFile(): void
    {
        $file = base_path('app-modules/Posts/routes.php');

        $generator = $this->generator('Post', 'Posts');
        $generator->write();

        $generator = $this->generator('Comment', 'Posts');
        $generator->write();

        $generator = $this->generator('Video', 'Posts');
        $generator->write();

        $this->assertFileContainsStrings($file, [
            'use Illuminate\Support\Facades\Route;',
            "Route::apiResource('posts', \App\Modules\Posts\Http\Controllers\PostController::class);",
            "Route::apiResource('comments', \App\Modules\Posts\Http\Controllers\CommentController::class);",
            "Route::apiResource('videos', \App\Modules\Posts\Http\Controllers\VideoController::class);",
        ]);
    }
}
