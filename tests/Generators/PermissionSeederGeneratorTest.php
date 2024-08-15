<?php

namespace Axyr\CrudGenerator\Tests\Generators;

use Axyr\CrudGenerator\Generators\PermissionSeederGenerator;

class PermissionSeederGeneratorTest extends GeneratorTestAbstract
{
    public function generatorClassName(): string
    {
        return PermissionSeederGenerator::class;
    }

    public static function dataGenerator(): array
    {
        return [
            [
                'name' => 'Comment',
                'module' => 'Posts',
                'expectedPath' => 'app-modules/Posts/src/Seeders/CommentPermissionSeeder.php',
                'expectedStrings' => [
                    'class CommentPermissionSeeder extends Seeder',
                    'namespace App\Modules\Posts\Seeders;',
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
