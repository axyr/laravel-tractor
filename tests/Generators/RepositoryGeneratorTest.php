<?php

namespace Axyr\CrudGenerator\Tests\Generators;

use Axyr\CrudGenerator\Generators\RepositoryGenerator;

class RepositoryGeneratorTest extends GeneratorTestAbstract
{
    public function generatorClassName(): string
    {
        return RepositoryGenerator::class;
    }

    public static function dataModelGenerator(): array
    {
        return [
            [
                'name' => 'Post',
                'module' => '',
                'expectedPath' => 'app/Modules/Posts/Repositories/PostRepository.php',
                'expectedNamespace' => 'App\\Modules\\Posts\\Repositories',
            ],
            [
                'name' => 'Comment',
                'module' => 'Posts',
                'expectedPath' => 'app/Modules/Posts/Repositories/CommentRepository.php',
                'expectedNamespace' => 'App\\Modules\\Posts\\Repositories',
            ],
        ];
    }

    public static function dataModelWriteTest(): array
    {
        return [
            [
                'name' => 'Comment',
                'module' => 'Posts',
                'expectedPath' => 'app/Modules/Posts/Repositories/CommentRepository.php',
                'expectedStrings' => [
                    'class CommentRepository',
                    'use App\Modules\Posts\Models\Comment;',
                    'use App\Modules\Posts\Filters\CommentFilter;',
                    'public function __construct(CommentFilter $filters)',
                    'return Comment::filterBy($this->filters);',
                ],
            ],
        ];
    }
}
