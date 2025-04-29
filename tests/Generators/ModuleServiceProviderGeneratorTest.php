<?php

namespace Axyr\Tractor\Tests\Generators;

use Axyr\Tractor\Generators\ModuleServiceProviderGenerator;

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
                    "Route::middleware('web')->prefix('abc')->group(function ()"
                ],
                'config' =>[
                    'tractor.route_middleware' => 'web',
                    'tractor.route_prefix' => 'abc'
                ]
            ],

            [
                'name' => 'Comment',
                'module' => 'Posts',
                'expectedPath' => 'app-modules/Posts/src/PostServiceProvider.php',
                'expectedStrings' => [
                    "Route::group(function ()"
                ],
                'config' =>[
                    'tractor.route_middleware' => '',
                    'tractor.route_prefix' => ''
                ]
            ],
        ];
    }

    public function testItDoesNotOverwriteAnExistingFile(): void
    {
        $expectedFile = base_path('app-modules/Posts/src/PostServiceProvider.php');

        // a Module can contain multiple CRUDs
        // we always only want to create a ModuleServiceProvider once
        $generator = $this->generator('Post', 'Posts');

        $this->assertTrue($generator->shouldWriteFile($expectedFile));

        $generator->write();

        $this->assertFalse($generator->shouldWriteFile($expectedFile));
    }
}
