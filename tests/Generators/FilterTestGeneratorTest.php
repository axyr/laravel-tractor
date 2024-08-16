<?php

namespace Axyr\CrudGenerator\Tests\Generators;

use Axyr\CrudGenerator\Generators\FilterTestGenerator;

class FilterTestGeneratorTest extends GeneratorTestAbstract
{
    public function generatorClassName(): string
    {
        return FilterTestGenerator::class;
    }

    public static function dataGenerator(): array
    {
        return [
            [
                'name' => 'Post',
                'module' => 'Posts',
                'expectedPath' => 'app-modules/Posts/tests/Filters/PostFilterTest.php',
                'expectedStrings' => [
                    'namespace App\Modules\Posts\Tests\Filters;',
                    'class PostFilterTest extends TestCase',
                    'use App\Modules\Posts\Factories\PostFactory;',
                    'use App\Modules\Posts\Filters\PostFilter;',
                    'use App\Modules\Posts\Models\Post;',
                ],
            ],
        ];
    }
}
