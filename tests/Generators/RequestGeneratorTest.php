<?php

namespace Axyr\CrudGenerator\Tests\Generators;

use Axyr\CrudGenerator\Generators\RequestGenerator;

class RequestGeneratorTest extends GeneratorTestAbstract
{
    public function generatorClassName(): string
    {
        return RequestGenerator::class;
    }

    public static function dataModelGenerator(): array
    {
        return [
            [
                'name' => 'Post',
                'module' => '',
                'expectedPath' => 'app/Modules/Posts/Http/Requests/PostRequest.php',
                'expectedNamespace' => 'App\\Modules\\Posts\\Http\\Requests',
            ],
        ];
    }

    public static function dataModelWriteTest(): array
    {
        return [
            [
                'name' => 'Post',
                'module' => 'Posts',
                'expectedPath' => 'app/Modules/Posts/Http/Requests/PostRequest.php',
                'expectedStrings' => [
                    'class PostRequest extends FormRequest',
                    'namespace App\Modules\Posts\Http\Requests;',
                ],
            ],
        ];
    }
}
