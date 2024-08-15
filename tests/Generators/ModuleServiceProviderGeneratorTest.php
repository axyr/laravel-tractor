<?php

namespace Axyr\CrudGenerator\Tests\Generators;

use Axyr\CrudGenerator\Generators\ModuleServiceProviderGenerator;

class ModuleServiceProviderGeneratorTest extends GeneratorTestAbstract
{
    public function generatorClassName(): string
    {
        return ModuleServiceProviderGenerator::class;
    }

    public static function dataGenerator(): array
    {
        return [
            [
                'name' => 'Comment',
                'module' => 'Posts',
                'expectedPath' => 'app-modules/Posts/src/PostServiceProvider.php',
                'expectedStrings' => [
                    'class PostServiceProvider extends ServiceProvider',
                ],
            ],
        ];
    }
}
