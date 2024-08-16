<?php

namespace Axyr\Tractor\Tests\Generators;

use Axyr\Tractor\Generators\FactoryGenerator;

class FactoryGeneratorTest extends GeneratorTestAbstract
{
    public function generatorClassName(): string
    {
        return FactoryGenerator::class;
    }

    public static function dataGenerator(): array
    {
        return [
            [
                'name' => 'Comment',
                'module' => 'Posts',
                'expectedPath' => 'app-modules/Posts/src/Factories/CommentFactory.php',
                'expectedStrings' => [
                    'class CommentFactory extends Factory',
                    'namespace App\Modules\Posts\Factories;',
                    'use App\Modules\Posts\Models\Comment;',
                ],
            ],
        ];
    }
}
