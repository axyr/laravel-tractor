<?php

namespace Axyr\CrudGenerator\Tests\Generators;

use Axyr\CrudGenerator\Generators\ModelGenerator;

class SrcDirectoryGeneratorTest extends GeneratorTestAbstract
{
    public function generatorClassName(): string
    {
        return ModelGenerator::class;
    }

    public static function dataGenerator(): array
    {
        return [
            [
                'name' => 'Comment',
                'module' => 'Posts',
                'expectedPath' => 'app-modules/Posts/Models/Comment.php',
                'expectedStrings' => [
                    'class Comment extends Model',
                    'namespace App\Modules\Posts\Models;',
                ],
                'config' => [
                    'crudgenerator.src_directory' => '',
                ],
            ],
        ];
    }
}
