<?php

namespace Axyr\Tractor\Tests\Generators;

use Axyr\Tractor\Generators\AbstractGenerator;
use Axyr\Tractor\Tests\TestCase;
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

        $this->assertFileContainsStrings($expectedFile, $expectedStrings);
    }

    public function generator(string $name, string $module): AbstractGenerator
    {
        $generatorClassName = $this->generatorClassName();
        return new $generatorClassName($name, $module ?: null);
    }

    public function assertFileContainsStrings(string $file, array $strings): void
    {
        $content = file_get_contents($file);

        foreach ($strings as $string) {
            $this->assertStringContainsString($string, $content);
        }
    }

    abstract public function generatorClassName(): string;

    abstract public static function dataGenerator(): array;
}
