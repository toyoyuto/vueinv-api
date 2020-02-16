<?php

namespace App\Console\Commands\Make;

use Illuminate\Foundation\Console\ModelMakeCommand;
use Symfony\Component\Console\Input\InputOption;

class Model extends ModelMakeCommand
{
    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        if ($this->option('pivot')) {
            return parent::getStub();
        }

        return __DIR__ . '/stubs/model.stub';
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
        return $rootNamespace . '\ORM';
    }

    /**
     * {@inheritdoc}
     *
     * @see \Illuminate\Foundation\Console\ModelMakeCommand::getOptions()
     */
    protected function getOptions()
    {
        return array_merge(
            parent::getOptions(),
            [
                ['table', 't', InputOption::VALUE_OPTIONAL, '実テーブル名'],
            ]
        );
    }

    /**
     * {@inheritdoc}
     *
     * @see \Illuminate\Console\GeneratorCommand::buildClass()
     */
    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());

        return $this->replaceTable($stub, $name)
            ->replaceNamespace($stub, $name)
            ->replaceClass($stub, $name);
    }

    protected function replaceTable(&$stub, $name)
    {
        if (!$this->option('table')) {
            $stub = str_replace("    protected \$table = 'DummyTable';\n", '', $stub);
        } else {
            $stub = str_replace('DummyTable', $this->option('table'), $stub);
        }

        return $this;
    }
}
