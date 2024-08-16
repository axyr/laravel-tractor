<?php

namespace Axyr\Tractor\Tests\Generators;

use Axyr\Tractor\Generators\ControllerGenerator;

class ControllerGeneratorTest extends GeneratorTestAbstract
{
    public function generatorClassName(): string
    {
        return ControllerGenerator::class;
    }

    public static function dataGenerator(): array
    {
        return [
            [
                'name' => 'Comment',
                'module' => 'Posts',
                'expectedPath' => 'app-modules/Posts/src/Http/Controllers/CommentController.php',
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
