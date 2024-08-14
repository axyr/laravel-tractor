<?php

namespace Axyr\CrudGenerator\Tests\Generators;

use Axyr\CrudGenerator\Generators\PolicyGenerator;

class PolicyGeneratorTest extends GeneratorTestAbstract
{
    public function generatorClassName(): string
    {
        return PolicyGenerator::class;
    }

    public static function dataModelGenerator(): array
    {
        return [
            [
                'name' => 'Post',
                'module' => '',
                'expectedPath' => 'app/Modules/Posts/Policies/PostPolicy.php',
                'expectedNamespace' => 'App\\Modules\\Posts\\Policies',
            ],
            [
                'name' => 'Comment',
                'module' => 'Posts',
                'expectedPath' => 'app/Modules/Posts/Policies/CommentPolicy.php',
                'expectedNamespace' => 'App\\Modules\\Posts\\Policies',
            ],
        ];
    }

    public static function dataModelWriteTest(): array
    {
        return [
            [
                'name' => 'Comment',
                'module' => 'Posts',
                'expectedPath' => 'app/Modules/Posts/Policies/CommentPolicy.php',
                'expectedStrings' => [
                    'class CommentPolicy',
                    'namespace App\Modules\Posts\Policies;',
                    'use Illuminate\Foundation\Auth\User;',
                    'use App\Modules\Posts\Models\Comment;',
                    'Comment $comment',
                    'comment.viewAny',
                    'comment.view',
                    'comment.create',
                    'comment.update',
                    'comment.delete',
                ],
            ],
        ];
    }
}
