<?php

namespace Axyr\Tractor\Tests\Generators;

use Axyr\Tractor\Generators\ModelGenerator;

class ModelGeneratorTest extends GeneratorTestAbstract
{
    public function generatorClassName(): string
    {
        return ModelGenerator::class;
    }

    public static function dataGenerator(): array
    {
        return [
            [
                'name' => 'Post',
                'module' => '',
                'expectedPath' => 'app-modules/Posts/src/Models/Post.php',
                'expectedStrings' => [
                    'class Post extends Model',
                    'namespace App\Modules\Posts\Models;',
                ],
            ],
            [
                'name' => 'Comment',
                'module' => 'Posts',
                'expectedPath' => 'app-modules/Posts/src/Models/Comment.php',
                'expectedStrings' => [
                    'class Comment extends Model',
                    'namespace App\Modules\Posts\Models;',
                ],
            ],
            [
                'name' => 'Articles',
                'module' => '',
                'expectedPath' => 'app-modules/Articles/src/Models/Article.php',
                'expectedStrings' => [
                    'class Article extends Model',
                    'namespace App\Modules\Articles\Models;',
                ],
            ],
        ];
    }
}
