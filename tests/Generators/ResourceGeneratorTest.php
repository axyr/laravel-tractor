<?php

namespace Axyr\Tractor\Tests\Generators;

use Axyr\Tractor\Generators\ResourceGenerator;

class ResourceGeneratorTest extends GeneratorTestAbstract
{
    public function generatorClassName(): string
    {
        return ResourceGenerator::class;
    }

    public static function dataGenerator(): array
    {
        return [
            [
                'name' => 'Post',
                'module' => 'Posts',
                'expectedPath' => 'app-modules/Posts/src/Http/Resources/PostResource.php',
                'expectedStrings' => [
                    'class PostResource extends JsonResource',
                    'namespace App\Modules\Posts\Http\Resources;',
                    '@mixin \App\Modules\Posts\Models\Post',
                ],
            ],
        ];
    }
}
