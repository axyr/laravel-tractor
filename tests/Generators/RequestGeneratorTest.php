<?php

namespace Axyr\CrudGenerator\Tests\Generators;

use Axyr\CrudGenerator\Generators\RequestGenerator;

class RequestGeneratorTest extends GeneratorTestAbstract
{
    public function generatorClassName(): string
    {
        return RequestGenerator::class;
    }

    public static function dataGenerator(): array
    {
        return [
            [
                'name' => 'Post',
                'module' => 'Posts',
                'expectedPath' => 'app-modules/Posts/src/Http/Requests/PostRequest.php',
                'expectedStrings' => [
                    'class PostRequest extends FormRequest',
                    'namespace App\Modules\Posts\Http\Requests;',
                ],
            ],
        ];
    }
}
