<?php

namespace Axyr\CrudGenerator\Tests\Generators;

use Axyr\CrudGenerator\Generators\RepositoryGenerator;

class RepositoryGeneratorTest extends GeneratorTestAbstract
{
    public function generatorClassName(): string
    {
        return RepositoryGenerator::class;
    }

    public static function dataGenerator(): array
    {
        return [
            [
                'name' => 'Comment',
                'module' => 'Posts',
                'expectedPath' => 'app-modules/Posts/src/Repositories/CommentRepository.php',
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
