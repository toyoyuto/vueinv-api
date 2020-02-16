<?php

namespace App\Console\Commands\Make;

use Illuminate\Console\Command;
use Illuminate\Foundation\Console\ResourceMakeCommand;
use Symfony\Component\Console\Input\InputOption;

class Resource extends ResourceMakeCommand
{
    use BuildReplacementsTrate;

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return $this->collection()
                ? __DIR__ . '/stubs/resource-collection.stub'
                : __DIR__ . '/stubs/resource.stub';
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array_merge(parent::getOptions(), [
            ['model', 'm', InputOption::VALUE_OPTIONAL, 'model name'],
        ]);
    }

    protected function buildDummiesReplacements(array $replaces, $name)
    {
        return array_merge($replaces, [
            'DummySwagger' => $this->collection() ? '' : $this->makeSwagger($replaces, $name),
        ]);
    }

    protected function makeSwagger(array $replaces, $name)
    {
        $swaggerLines = ['    /**'];

        foreach ($replaces['Columns'] as $column) {
            $type   = 'string';
            $format = '';

            switch ($column->ColumnType) {
                case 'integer':
                    $type = 'integer';
                    break;
                case 'boolean':
                    $type = 'boolean';
                    break;
                case 'datetime':
                    $format = ', format="dateTime"';
                    break;
                default:
                    break;
            }

            $swaggerLines[] = "     * @SWG\\Property(property=\"{$column->Field}\", description=\"{$column->Commnet}\", type=\"{$type}\"{$format})";
        }

        $swaggerLines[] = '     */';

        return implode("\n", $swaggerLines);
    }
}
