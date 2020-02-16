<?php

namespace App\Console\Commands\Make;

use Illuminate\Console\Command;
use Illuminate\Foundation\Console\RequestMakeCommand;
use Symfony\Component\Console\Input\InputOption;

class Request extends RequestMakeCommand
{
    use BuildReplacementsTrate;

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/request.stub';
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
        $swagger    = $this->makeSwagger($replaces, $name);
        $definition = "/**\n * @SWG\\Definition(definition=\"" . $replaces['DummySwaggerDefinitionsHead'] . class_basename($name) . "\", type=\"object\")\n */";

        if (!$swagger) {
            $swagger = '';
        }

        return array_merge($replaces, [
            'DummyDefinition' => $definition,
            'DummySwagger'    => $swagger,
            'DummyRule'       => $this->makeRule($replaces, $name),
        ]);
    }

    protected function makeRule(array $replaces, $name)
    {
        preg_match('/^.*\\\\(\w+)((Search|Store|Update)Request)/', $name, $matches);
        $method = $matches[3];

        if (!$method) {
            return '';
        }

        if ($method === 'Search') {
            return <<<'EOF'
            'per_page' => 'nullable|integer',
            'page' => 'nullable|integer',
EOF;
        }

        $ruleLines = [];

        foreach ($replaces['Columns'] as $column) {
            if ($column->Key === 'PRI') {
                continue;
            }

            $rules = [];

            if ($method === 'Store' && $column->Null === 'NO') {
                $rules[] = 'required';
            } else {
                $rules[] = 'nullable';
            }

            switch ($column->ColumnType) {
                case 'integer':
                    $rules[] = 'integer';
                    break;
                case 'boolean':
                    $rules[] = 'boolean';
                    break;
                case 'datetime':
                    $rules[] = 'date';
                    break;
                default:
                    $rules[] = 'string';

                    if ($column->ColumnSize) {
                        $rules[] = "max:{$column->ColumnSize}";
                    }
                    break;
            }

            $ruleLines[] = "            '{$column->Field}' => '" . implode('|', $rules) . "',";
        }

        return implode("\n", $ruleLines);
    }

    protected function makeSwagger(array $replaces, $name)
    {
        preg_match('/^.*\\\\(\w+)((Search|Store|Update)Request)/', $name, $matches);
        $method = $matches[3];

        if (!$method) {
            return '';
        }

        if ($method === 'Search') {
            return '';
        }

        $swaggerLines = ['    /**'];

        foreach ($replaces['Columns'] as $column) {
            if ($column->Key === 'PRI') {
                continue;
            }

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
