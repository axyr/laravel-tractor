<?php

namespace Axyr\CrudGenerator\Tests\Generators;

use Axyr\CrudGenerator\Generators\PermissionSeederGenerator;

class PermissionSeederGeneratorTest extends GeneratorTestAbstract
{
    public function generatorClassName(): string
    {
        return PermissionSeederGenerator::class;
    }

    public static function dataModelGenerator(): array
    {
        return [
            [
                'name' => 'Comment',
                'module' => 'Posts',
                'expectedPath' => 'app/Modules/Posts/Seeders/CommentPermissionSeeder.php',
                'expectedNamespace' => 'App\\Modules\\Posts\\Seeders',
            ],
        ];
    }

    public static function dataModelWriteTest(): array
    {
        return [
            [
                'name' => 'Comment',
                'module' => 'Posts',
                'expectedPath' => 'app/Modules/Posts/Seeders/CommentPermissionSeeder.php',
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
