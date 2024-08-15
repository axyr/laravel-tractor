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
                    'use App\Modules\Posts\Http\Controllers\CommentController;',
                    "Route::apiResource('comments', CommentController::class);",
                ],
            ],
        ];
    }
}
