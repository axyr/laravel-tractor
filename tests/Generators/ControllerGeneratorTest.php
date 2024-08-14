<?php

namespace Axyr\CrudGenerator\Tests\Generators;

use Axyr\CrudGenerator\Generators\ControllerGenerator;

class ControllerGeneratorTest extends GeneratorTestAbstract
{
    public function generatorClassName(): string
    {
        return ControllerGenerator::class;
    }

    public static function dataModelGenerator(): array
    {
        return [
            [
                'name' => 'Post',
                'module' => '',
                'expectedPath' => 'app/Modules/Posts/Http/Controllers/PostController.php',
                'expectedNamespace' => 'App\\Modules\\Posts\\Http\\Controllers',
            ],
        ];
    }

    public static function dataModelWriteTest(): array
    {
        return [
            [
                'name' => 'Comment',
                'module' => 'Posts',
                'expectedPath' => 'app/Modules/Posts/Http/Controllers/CommentController.php',
                'expectedStrings' => [
                    'class CommentController extends Controller',
                    'namespace App\Modules\Posts\Http\Controllers;',
                    'use App\Modules\Posts\Models\Comment;',
                    'use App\Modules\Posts\Repositories\CommentRepository;',
                    'use App\Modules\Posts\Http\Requests\CommentRequest;',
                    'use App\Modules\Posts\Http\Resources\CommentResource;',
                    'public function __construct(protected CommentRepository $repository)',
                    '$this->authorizeResource(Comment::class);',
                    'return CommentResource::collection($comments)->preserveQuery();',
                    'public function store(CommentRequest $request): CommentResource',
                    'return new CommentResource($comment);',
                    'public function show(Comment $comment): CommentResource',
                    'public function update(CommentRequest $request, Comment $comment): CommentResource',
                    '$comment->update($request->validated());',
                    'public function destroy(Comment $comment): Response',
                    '$comment->delete();',
                ],
            ],
        ];
    }
}
