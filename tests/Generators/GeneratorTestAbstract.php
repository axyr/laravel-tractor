<?php

namespace Axyr\CrudGenerator\Tests\Generators;

use Axyr\CrudGenerator\Generators\AbstractGenerator;
use Axyr\CrudGenerator\Tests\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

abstract class GeneratorTestAbstract extends TestCase
{
    #[DataProvider('dataModelGenerator')]
    public function testModelGenerator(string $name, string $module, string $expectedPath, string $expectedNamespace): void
    {
        $generator = $this->generator($name, $module);

        $this->assertEquals($expectedPath, $generator->path());
        $this->assertEquals($expectedNamespace, $generator->namespace());
    }

    abstract public static function dataModelGenerator(): array;

    #[DataProvider('dataModelWriteTest')]
    public function testModelWriteTest(string $name, string $module, string $expectedPath, array $expectedStrings = []): void
    {
        $generator = $this->generator($name, $module);

        $generator->write();

        $this->assertFileExists($expectedFile = base_path($expectedPath));

        $content = file_get_contents($expectedFile);

        foreach ($expectedStrings as $expectedString) {
            $this->assertStringContainsString($expectedString, $content);
        }
    }

    private function generator(string $name, string $module): AbstractGenerator
    {
        $generatorClassName = $this->generatorClassName();
        return new $generatorClassName($name, $module ?: null);
    }

    abstract public function generatorClassName(): string;

    abstract public static function dataModelWriteTest(): array;
}
