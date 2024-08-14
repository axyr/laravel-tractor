<?php

namespace Axyr\CrudGenerator\Tests\Generators;

use Axyr\CrudGenerator\Generators\FilterGenerator;

class FilterGeneratorTest extends GeneratorTestAbstract
{
    public function generatorClassName(): string
    {
        return FilterGenerator::class;
    }

    public static function dataModelGenerator(): array
    {
        return [
            [
                'name' => 'Post',
                'module' => '',
                'expectedPath' => 'app/Modules/Posts/Filters/PostFilter.php',
                'expectedNamespace' => 'App\\Modules\\Posts\\Filters',
            ],
            [
                'name' => 'Comment',
                'module' => 'Posts',
                'expectedPath' => 'app/Modules/Posts/Filters/CommentFilter.php',
                'expectedNamespace' => 'App\\Modules\\Posts\\Filters',
            ],
        ];
    }

    public static function dataModelWriteTest(): array
    {
        return [
            [
                'name' => 'Comment',
                'module' => 'Posts',
                'expectedPath' => 'app/Modules/Posts/Filters/CommentFilter.php',
                'expectedStrings' => [
                    'class CommentFilter',
                ],
            ],
        ];
    }
}
