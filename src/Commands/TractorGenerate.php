<?php

namespace Axyr\Tractor\Commands;

use Axyr\Tractor\Generators\CombinedGenerator;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;

class TractorGenerate extends Command
{
    protected $signature = 'tractor:generate
        { name : The model to generate }
        { --a|all : Generate all related classes (migration, permission seeder, factory, policy, resource controller, form request, repository, and filter) }
        { --m|migration : Create a new migration file for the model }
        { --module= : The module name to generate the model in (defaults to plural form of the name) }
    ';

    protected $description = 'Generate a complete RESTful JSON API module structure for the given model.';

    public function handle(): void
    {
        if ($this->option('all')) {
            $this->input->setOption('migration', true);
        }

        $this->createClassFiles();

        if ($this->option('migration')) {
            $this->createMigration();
        }

        $this->runComposerDumpAutoload();
    }

    protected function createClassFiles(): void
    {
        $generator = new CombinedGenerator($this->argument('name'), $this->option('module'));

        $this->info('Generating class files...');
        $generator->generate();

        foreach ($generator->generatedFiles() as $file) {
            $this->line($file);
        }

        $this->info('Class generation complete.');
    }

    protected function createMigration(): void
    {
        $table = Str::plural(Str::snake($this->argument('name')));
        $migrationName = "create_{$table}_table";

        $this->call('make:migration', ['name' => $migrationName]);
    }

    protected function runComposerDumpAutoload(): void
    {
        $this->info('Running composer dump-autoload...');

        $process = Process::fromShellCommandline('composer dump-autoload');
        $process->run();

        if ($process->isSuccessful()) {
            $this->info('Composer autoload updated.');
        } else {
            $this->error('Failed to run composer dump-autoload.');
            $this->line($process->getErrorOutput());
        }
    }
}
