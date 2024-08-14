<?php

namespace Axyr\CrudGenerator\Tests\Generators;

use Axyr\CrudGenerator\Generators\FactoryGenerator;

class FactoryGeneratorTest extends GeneratorTestAbstract
{
    public function generatorClassName(): string
    {
        return FactoryGenerator::class;
    }

    public static function dataModelGenerator(): array
    {
        return [
            [
                'name' => 'Post',
                'module' => '',
                'expectedPath' => 'app/Modules/Posts/Factories/PostFactory.php',
                'expectedNamespace' => 'App\\Modules\\Posts\\Factories',
            ],
            [
                'name' => 'Comment',
                'module' => 'Posts',
                'expectedPath' => 'app/Modules/Posts/Factories/CommentFactory.php',
                'expectedNamespace' => 'App\\Modules\\Posts\\Factories',
            ],
        ];
    }

    public static function dataModelWriteTest(): array
    {
        return [
            [
                'name' => 'Comment',
                'module' => 'Posts',
                'expectedPath' => 'app/Modules/Posts/Factories/CommentFactory.php',
                'expectedStrings' => [
                    'class CommentFactory extends Factory',
                    'namespace App\Modules\Posts\Factories;',
                    'use App\Modules\Posts\Models\Comment;',
                ],
            ],
        ];
    }
}
