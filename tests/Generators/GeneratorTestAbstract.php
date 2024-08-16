<?php

namespace Axyr\CrudGenerator\Tests\Generators;

use Axyr\CrudGenerator\Generators\AbstractGenerator;
use Axyr\CrudGenerator\Tests\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

abstract class GeneratorTestAbstract extends TestCase
{
    #[DataProvider('dataGenerator')]
    public function testGenerator(string $name, string $module, string $expectedPath, array $expectedStrings = [], array $config = []): void
    {
        foreach ($config as $key => $value) {
            config()->set($key, $value);
        }

        $generator = $this->generator($name, $module);

        $generator->write();

        $this->assertFileExists($expectedFile = base_path($expectedPath));

        $content = file_get_contents($expectedFile);

        foreach ($expectedStrings as $expectedString) {
            $this->assertStringContainsString($expectedString, $content);
        }
    }

    public function generator(string $name, string $module): AbstractGenerator
    {
        $generatorClassName = $this->generatorClassName();
        return new $generatorClassName($name, $module ?: null);
    }

    abstract public function generatorClassName(): string;

    abstract public static function dataGenerator(): array;
}
