<?php

namespace Axyr\CrudGenerator\Commands;

use Axyr\CrudGenerator\Generators\CombinedGenerator;
use Illuminate\Console\Command;

class GenerateCrud extends Command
{
    protected $signature = 'crud:generate
        { name : The Model to generate }
        { --module= : The Module name to generate the Model in. Defaults to plural form of the name argument }';

    protected $description = 'Generate a set of classes to manage a resource crud.';

    public function handle(): void
    {
        $generator = new CombinedGenerator($this->argument('name'), $this->option('module'));

        $generator->generate();

        foreach ($generator->generatedFiles() as $generatedFile) {
            $this->line($generatedFile);
        }
    }
}
