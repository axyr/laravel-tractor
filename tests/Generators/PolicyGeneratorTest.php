<?php

namespace Axyr\Tractor\Tests\Generators;

use Axyr\Tractor\Generators\PolicyGenerator;

class PolicyGeneratorTest extends GeneratorTestAbstract
{
    public function generatorClassName(): string
    {
        return PolicyGenerator::class;
    }

    public static function dataGenerator(): array
    {
        return [
            [
                'name' => 'Comment',
                'module' => 'Posts',
                'expectedPath' => 'app-modules/Posts/src/Policies/CommentPolicy.php',
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
