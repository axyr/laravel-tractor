<?php

namespace Axyr\Tractor\Tests\Generators;

use Axyr\Tractor\Generators\ComposerGenerator;

class ComposerGeneratorTest extends GeneratorTestAbstract
{
    public function generatorClassName(): string
    {
        return ComposerGenerator::class;
    }

    public static function dataGenerator(): array
    {
        return [
            [
                'name' => 'Post',
                'module' => '',
                'expectedPath' => 'app-modules/Posts/composer.json',
                'expectedStrings' => [
                    '"name": "app/posts"',
                    '"App\\\\Modules\\\\Posts\\\\": "src/"',
                    '"App\\\\Modules\\\\Posts\\\\Tests\\\\": "tests/"',
                    '"App\\\\Modules\\\\Posts\\\\PostServiceProvider"',
                ],
            ],
        ];
    }
}
