<?php

namespace Axyr\CrudGenerator\Tests\Generators;

use Axyr\CrudGenerator\Generators\ModelGenerator;

class ModelGeneratorTest extends GeneratorTestAbstract
{
    public function generatorClassName(): string
    {
        return ModelGenerator::class;
    }

    public static function dataModelGenerator(): array
    {
        return [
            [
                'name' => 'Post',
                'module' => '',
                'expectedPath' => 'app/Modules/Posts/Models/Post.php',
                'expectedNamespace' => 'App\\Modules\\Posts\\Models',
            ],
            [
                'name' => 'Comment',
                'module' => 'Posts',
                'expectedPath' => 'app/Modules/Posts/Models/Comment.php',
                'expectedNamespace' => 'App\\Modules\\Posts\\Models',
            ],
            [
                'name' => 'Articles',
                'module' => '',
                'expectedPath' => 'app/Modules/Articles/Models/Article.php',
                'expectedNamespace' => 'App\\Modules\\Articles\\Models',
            ],
        ];
    }

    public static function dataModelWriteTest(): array
    {
        return [
            [
                'name' => 'Comment',
                'module' => 'Posts',
                'expectedPath' => 'app/Modules/Posts/Models/Comment.php',
                'expectedStrings' => [
                    'class Comment extends Model',
                    'namespace App\Modules\Posts\Models;',
                ],
            ],
        ];
    }
}
