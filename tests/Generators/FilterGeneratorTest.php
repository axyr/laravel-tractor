<?php

namespace Axyr\Tractor\Tests\Generators;

use Axyr\Tractor\Generators\FilterGenerator;

class FilterGeneratorTest extends GeneratorTestAbstract
{
    public function generatorClassName(): string
    {
        return FilterGenerator::class;
    }

    public static function dataGenerator(): array
    {
        return [
            [
                'name' => 'Comment',
                'module' => 'Posts',
                'expectedPath' => 'app-modules/Posts/src/Filters/CommentFilter.php',
                'expectedStrings' => [
                    'namespace App\Modules\Posts\Filters;',
                    'class CommentFilter',
                ],
            ],
        ];
    }
}
