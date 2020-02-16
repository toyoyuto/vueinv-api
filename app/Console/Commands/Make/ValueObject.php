<?php

namespace App\Console\Commands\Make;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

class ValueObject extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:valueObject';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new ValueObject class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'ValueObject';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/value-object.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     *
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\ValueObjects';
    }

    /**
     * {@inheritdoc}
     *
     * @see \Illuminate\Console\GeneratorCommand::buildClass()
     */
    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());

        return $this->replaceNamespace($stub, $name)
            ->replaceClass($stub, $name);
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['model', 'm', InputOption::VALUE_OPTIONAL, 'model name'],
            ['module_relative_path', 'r', InputOption::VALUE_OPTIONAL, 'module relative path'],
        ];
    }
}
