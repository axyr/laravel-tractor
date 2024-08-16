<?php

namespace Axyr\Tractor\Commands;

use Axyr\Tractor\Generators\CombinedGenerator;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class TractorGenerate extends Command
{
    protected $signature = 'tractor:generate
        { name : The Model to generate }
        { --a|all : Generate a migration, permission seeder, factory, policy, resource controller, form request, repository and filter classes for the model }
        { --m|migration : Create a new migration file for the model }
        { --module= : The Module name to generate the Model in. Defaults to plural form of the name argument }
    ';

    protected $description = 'Generate a module structure for a restfull resource based json api module.';

    public function handle(): void
    {
        if ($this->option('all')) {
            $this->input->setOption('migration', true);
        }

        $this->createClassFiles();

        if ($this->option('migration')) {
            $this->createMigration();
        }
    }

    public function createClassFiles(): void
    {
        $generator = new CombinedGenerator($this->argument('name'), $this->option('module'));

        $this->info('Generating classes');

        $generator->generate();

        foreach ($generator->generatedFiles() as $generatedFile) {
            $this->line($generatedFile);
        }

        $this->info('Classes generated');
    }

    public function createMigration(): void
    {
        $name = sprintf('create_%s_table', strtolower(Str::plural($this->argument('name'))));

        $this->call('make:migration', [
            'name' => $name,
        ]);
    }
}
