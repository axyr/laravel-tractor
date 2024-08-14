<?php

namespace Axyr\CrudGenerator\Tests\Generators;

use Axyr\CrudGenerator\Generators\ResourceGenerator;

class ResourceGeneratorTest extends GeneratorTestAbstract
{
    public function generatorClassName(): string
    {
        return ResourceGenerator::class;
    }

    public static function dataModelGenerator(): array
    {
        return [
            [
                'name' => 'Post',
                'module' => '',
                'expectedPath' => 'app/Modules/Posts/Http/Resources/PostResource.php',
                'expectedNamespace' => 'App\\Modules\\Posts\\Http\\Resources',
            ],
        ];
    }

    public static function dataModelWriteTest(): array
    {
        return [
            [
                'name' => 'Post',
                'module' => 'Posts',
                'expectedPath' => 'app/Modules/Posts/Http/Resources/PostResource.php',
                'expectedStrings' => [
                    'class PostResource extends JsonResource',
                    'namespace App\Modules\Posts\Http\Resources;',
                    '@mixin \App\Modules\Posts\Models\Post',
                ],
            ],
        ];
    }
}
