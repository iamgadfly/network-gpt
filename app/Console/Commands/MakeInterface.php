<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Composer;
use Symfony\Component\Console\Input\InputOption;

class MakeInterface extends GeneratorCommand
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:interface {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make interface';

    protected $type = 'Interface';

    protected Composer $composer;

    public function __construct(Filesystem $files, Composer $composer)
    {
        parent::__construct($files);

        $this->composer = $composer;
    }

    public function getStub(): string
    {
        return base_path('stubs/interface.stub');
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace.'\Interfaces';
    }

    protected function buildClass($name): string
    {
        $stub = $this->files->get($this->getStub());

        return $this->replaceNamespace($stub, $name)->replaceClass(
            $stub,
            $name
        );
    }

    protected function getOptions(): array
    {
        return [
            [
                'force',
                null,
                InputOption::VALUE_NONE,
                'Create the class even if it already exists',
            ],
        ];
    }

    protected function getArguments(): array
    {
        return [
            ['name'],
        ];
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle()
    {
        parent::handle();
        app()->make(Composer::class)->dumpAutoloads();
    }

}
